<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Project;
use App\SubCompany;
use App\ServicingTeam;
use App\ServicingSetup;
use Illuminate\Http\Request;
use App\ServicingSetupRemark;
use App\ServicingTeamConnector;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use App\Services\ServicingSetupService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreServicingSetupRequest;
use App\Http\Requests\UpdateServicingSetupRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyServicingSetupRequest;
use App\Http\Requests\StoreServicingSetupActualDataRequest;
use App\Jobs\CompletingContractMaintenanceJob;
use App\Jobs\CompletingMaintenanceEstimatedDateJob;
use App\Jobs\CompletingMaintenanceJob;
use App\Jobs\CompletingServiceReportPdfJob;

class ServicingSetupController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('servicing_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetups = ServicingSetup::latest()->paginate(10);

        return view('admin.servicingSetups.index', compact('servicingSetups'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('servicing_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $project = Project::findOrFail($request->project_id);
        
        if ( $request->has('request_type') && ! is_null($request->request_type) ) {
            $request_type = $request->request_type;
        } else {
            abort(404);
        }

        $servicing_teams = ServicingTeam::cursor();

        $subcom_teams = SubCompany::cursor();

        return view('admin.servicingSetups.create', compact('project', 'request_type', 'servicing_teams', 'subcom_teams'));
    }

    public function store(StoreServicingSetupRequest $request) //StoreServicingSetupRequest
    {
        $servicingSetup = (new ServicingSetupService)->create($request->all());

        $servicingTeamConnector = ServicingTeamConnector::create([
            'servicing_setup_id' => $servicingSetup->id,
        ]);            

        $servicingTeam = ServicingTeam::findOrFail($request->servicing_team_id);

        $servicingTeamConnector->attachMorph($servicingTeam);        

        return redirect()->route('admin.servicing-setups.show', $servicingSetup->id);
    }

    public function edit(ServicingSetup $servicingSetup)
    {
        abort_if(Gate::denies('servicing_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeams = ServicingTeam::cursor();

        $subcomTeams = Subcompany::cursor();

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $projects = Project::cursor();

        $servicingSetup->load('project');

        return view('admin.servicingSetups.edit', compact('projects', 'servicingSetup', 'servicingTeams', 'subcomTeams'));
    }

    public function startMaintenance(ServicingSetup $servicingSetup)
    {
        $servicingTeams = ServicingTeam::cursor();

        $subcomTeams = Subcompany::cursor();

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        // $projects = Project::cursor();

        $servicingSetup->load('project');

        return view('admin.servicingSetups.startMaintenance', compact('projects', 'servicingSetup', 'servicingTeams', 'subcomTeams'));
    }

    public function update(UpdateServicingSetupRequest $request, ServicingSetup $servicingSetup) //UpdateServicingSetupRequest
    {                
        if ($request->team_type == 'inhouse') {
            $this->validate($request, [
                'servicing_team_id' => 'required',
            ]);
        } elseif ($request->team_type == 'subcom') {
            $this->validate($request, [
                'subcom_team_id' => 'required',
            ]);
        } elseif ($request->team_type == 'both') {
            $this->validate($request, [
                'servicing_team_id' => 'required',
                'subcom_team_id' => 'required',
            ]);
        } else {
            $this->validate($request,[
                'team_type' => 'required',
            ]);
        }
        
        $userId = auth()->user()->id;
        
        $data = $request->all();
        $data['updated_by_id'] = $userId;
        $data['status'] = config('status.servicingSetup.pending');
        
        $servicingSetup->update($data);
        
        
        if ($servicingSetup->request_type == 'Oncall') {
            $servicingSetup->oncall->status = config('status.oncall.ongoing');
            $servicingSetup->push();
        }
        
        $this->assignTeams($request->all(), $servicingSetup->id);

        dispatch(new CompletingMaintenanceJob($servicingSetup));
        
        return redirect()->route('admin.servicing-setups.show', [$servicingSetup]);
    }

    public function assignTeams($request, $servicing_setup_id)
    {
        if ( $request['team_type'] == 'inhouse' ) {

            $this->assignInhouseTeam($request['servicing_team_id'], $servicing_setup_id);

        } elseif ( $request['team_type'] == 'subcom' ) {

            $this->assignSubcomTeam($request['subcom_team_id'], $servicing_setup_id);

        } elseif ( $request['team_type'] == 'both' ) {

            $this->assignBoth($request['servicing_team_id'], $request['subcom_team_id'], $servicing_setup_id);

        }
    }

    public function assignInhouseTeam($servicing_team_id, $servicing_setup_id)
    {
        $servicingTeam = ServicingTeam::findOrFail($servicing_team_id);        

        $servicingTeamConnector = ServicingTeamConnector::create([
            'servicing_setup_id' => $servicing_setup_id,
        ]);

        $servicingTeamConnector->attachMorph($servicingTeam);
    }

    public function assignSubcomTeam($subcom_team_id, $servicing_setup_id)
    {
        $subcomTeam = SubCompany::findOrFail($subcom_team_id);        

        $servicingTeamConnector = ServicingTeamConnector::create([
            'servicing_setup_id' => $servicing_setup_id,
        ]);

        $servicingTeamConnector->attachMorph($subcomTeam);
    }

    public function assignBoth($servicing_team_id, $subcom_team_id, $servicing_setup_id)
    {        
        $servicingTeam = ServicingTeam::findOrFail($servicing_team_id);

        $subcomTeam = SubCompany::findOrFail($subcom_team_id);

        $servicingTeamConnectorForInhouse = ServicingTeamConnector::create([
            'servicing_setup_id' => $servicing_setup_id,
        ]);        
            
        $servicingTeamConnectorForInhouse->attachMorph($servicingTeam);

        $servicingTeamConnectorForSubcom = ServicingTeamConnector::create([
            'servicing_setup_id' => $servicing_setup_id,
        ]);

        $servicingTeamConnectorForSubcom->attachMorph($subcomTeam);
    }

    public function show(ServicingSetup $servicingSetup)
    {
        abort_if(Gate::denies('servicing_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeams = ServicingTeam::cursor();

        $subcomTeams = SubCompany::cursor();

        $servicingSetupRemarks = ServicingSetupRemark::cursor();

        $servicingSetup->load('project', 'created_by', 'updated_by');

        return view('admin.servicingSetups.show', compact('servicingSetup', 'servicingTeams', 'subcomTeams', 'servicingSetupRemarks'));
    }

    public function destroy(ServicingSetup $servicingSetup)
    {
        abort_if(Gate::denies('servicing_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetup->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicingSetupRequest $request)
    {
        ServicingSetup::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeActualActionData(StoreServicingSetupActualDataRequest $request, ServicingSetup $servicingSetup)
    {
        $userId = auth()->user()->id;

        $data = $request->all();
        
        $data['updated_by_id'] = $userId;        

        if($request->hasFile('service_report_pdf')){
            $title = $servicingSetup->id. '_service_report_pdf';
            $folder = config('bucket.repair');
            $url = $this->storeFileToBucket($title, $request->service_report_pdf, $folder);

            $data['service_report_pdf'] = $url;
            
            dispatch(new CompletingServiceReportPdfJob($servicingSetup));
        }
        $data['status'] = config('status.servicingSetup.complete');
        $servicingSetup->update($data);                
        
        if ($servicingSetup->request_type == 'Oncall') {

            if ($servicingSetup->service_report_pdf) {
                $servicingSetup->oncall->status = config('status.oncall.complete');
                $servicingSetup->push();
            }

        }
        
        if ($data['remark']) {
            ServicingSetupRemark::create([
                'remark' => $data['remark'],
                'servicing_setup_id' => $servicingSetup->id,
                'created_by_id' => $userId
            ]);
        }
        
        dispatch(new CompletingMaintenanceEstimatedDateJob($servicingSetup));
        dispatch(new CompletingContractMaintenanceJob($servicingSetup));

        return redirect()->route('admin.servicing-setups.show', [$servicingSetup]);
    }

    public function storeRemark(ServicingSetup $servicingSetup, Request $request){

        $userId = auth()->user()->id;
        
        $validatedData = $request->validate([
            'remark' => "required|string"
        ]);

        $validatedData['servicing_setup_id'] = $servicingSetup->id;
        $validatedData['created_by_id'] = $userId;

        ServicingSetupRemark::create($validatedData);

        return redirect()->route('admin.servicing-setups.show', [$servicingSetup]);
    }
}
