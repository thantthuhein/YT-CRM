<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\OnCall;
use App\Repair;
use App\SubCompany;
use App\RepairTeam;
use App\RepairTeamConnector;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyRepairRequest;
use App\Http\Requests\StoreRepairAcutalDataRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\UpdateActualActionRequest;
use App\Jobs\CompletingRepairEstimatedDateJob;
use App\Jobs\CompletingRepairServiceReportPdfJob;
use App\RepairRemark;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    use MediaUploadingTrait, ImageUploadTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('repair_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $team_type = $request->has('team_type') ? $request->team_type : 'all';
        
        $repairs = Repair::when($team_type != 'all', function($query) use ($team_type) {
            $query->where('team_type', $team_type);
        })
        ->with('oncall.project')
        ->latest()
        ->paginate(10);

        return view('admin.repairs.index', compact('repairs'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $oncalls = OnCall::all()->pluck('is_new_customer', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.repairs.create', compact('oncalls', 'created_bies', 'updated_bies'));
    }

    public function store(StoreRepairRequest $request)
    {
        $repair = Repair::create($request->all());

        if ($request->input('service_report_pdf', false)) {
            $repair->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf')))->toMediaCollection('service_report_pdf');
        }

        return redirect()->route('admin.repairs.index');
    }

    public function edit(Repair $repair)
    {
        abort_if(Gate::denies('repair_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $oncalls = OnCall::all()->pluck('is_new_customer', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $repair->load('oncall', 'created_by', 'updated_by');

        return view('admin.repairs.edit', compact('oncalls', 'created_bies', 'updated_bies', 'repair'));
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        if ($request->team_type == 'inhouse') {
            $this->validate($request, [
                'repair_team_id' => 'required',
            ]);
        } elseif ($request->team_type == 'subcom') {
            $this->validate($request, [
                'subcom_team_id' => 'required',
            ]);
        } elseif ($request->team_type == 'Both') {
            $this->validate($request, [
                'repair_team_id' => 'required',
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

        $repair->update($data);

        $repair->oncall->status = config('status.oncall.ongoing');
        $repair->push();
        
        $this->assignTeams($request->all(), $repair->id);

        return redirect()->route('admin.repairs.show', [$repair]);
    }

    public function assignTeams($request, $repair_id)
    {
        if ( $request['team_type'] == 'inhouse' ) {

            $this->assignInhouseTeam($request['repair_team_id'], $repair_id);

        } elseif ( $request['team_type'] == 'subcom' ) {

            $this->assignSubcomTeam($request['subcom_team_id'], $repair_id);

        } elseif ( $request['team_type'] == 'Both' ) {

            $this->assignBoth($request['repair_team_id'], $request['subcom_team_id'], $repair_id);

        }
    }
    public function assignInhouseTeam($repair_team_id, $repair_id)
    {
        $repairTeam = RepairTeam::findOrFail($repair_team_id);        

        $repairTeamConnector = RepairTeamConnector::create([
            'repair_id' => $repair_id,
        ]);

        $repairTeamConnector->attachMorph($repairTeam);
    }

    public function assignSubcomTeam($subcom_team_id, $repair_id)
    {
        $subcomTeam = SubCompany::findOrFail($subcom_team_id);        

        $repairTeamConnector = RepairTeamConnector::create([
            'repair_id' => $repair_id,
        ]);

        $repairTeamConnector->attachMorph($subcomTeam);
    }

    public function assignBoth($repair_team_id, $subcom_team_id, $repair_id)
    {        
        $repairTeam = RepairTeam::findOrFail($repair_team_id);

        $subcomTeam = SubCompany::findOrFail($subcom_team_id);

        $repairTeamConnectorForInhouse = RepairTeamConnector::create([
            'repair_id' => $repair_id,
        ]);        
            
        $repairTeamConnectorForInhouse->attachMorph($repairTeam);

        $repairTeamConnectorForSubcom = RepairTeamConnector::create([
            'repair_id' => $repair_id,
        ]);

        $repairTeamConnectorForSubcom->attachMorph($subcomTeam);
    }

    public function show(Repair $repair)
    {
        abort_if(Gate::denies('repair_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->load('oncall', 'created_by', 'updated_by');

        $repairTeams = RepairTeam::cursor();

        $subcomTeams = SubCompany::cursor();

        return view('admin.repairs.show', compact('repair', 'repairTeams', 'subcomTeams'));
    }

    public function destroy(Repair $repair)
    {
        abort_if(Gate::denies('repair_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairRequest $request)
    {
        Repair::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createActualActionData(Repair $repair){
        return view('admin.repairs.actualAction', compact('repair'));
    }

    public function storeActualActionData(StoreRepairAcutalDataRequest $request, Repair $repair)
    {
        $userId = auth()->user()->id;

        $data = $request->all();
        $data['updated_by_id'] = $userId;

        if($request->hasFile('service_report_pdf')){
            $title = $repair->id. '_service_report_pdf';
            $folder = config('bucket.repair');
            $url = $this->storeFileToBucket($title, $request->service_report_pdf, $folder);

            $data['service_report_pdf'] = $url;

            dispatch(new CompletingRepairServiceReportPdfJob($repair));
        }

        $repair->update($data);

        // service report pdf shi yin status ka ongoing
        if ($repair->service_report_pdf) {
            $repair->oncall->status = config('status.oncall.complete');
            $repair->push();
        }

        if (isset($data['remark'])) {
            RepairRemark::create([
                'remark' => $data['remark'],
                'repair_id' => $repair->id,
                'created_by_id' => $userId
            ]);
        }

        dispatch(new CompletingRepairEstimatedDateJob($repair));

        return redirect()->route('admin.repairs.show', [$repair]);
    }

    public function storeRemark(Repair $repair, Request $request){

        $userId = auth()->user()->id;
        
        $validatedData = $request->validate([
            'remark' => "required|string"
        ]);

        $validatedData['repair_id'] = $repair->id;
        $validatedData['created_by_id'] = $userId;

        RepairRemark::create($validatedData);

        return redirect()->route('admin.repairs.show', [$repair]);
    }

}
