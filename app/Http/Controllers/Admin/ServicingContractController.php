<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Project;
use Carbon\Carbon;
use App\ServicingSetup;
use App\ServicingContract;
use App\InHouseInstallation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreServicingContractRequest;
use App\Http\Requests\UpdateServicingContractRequest;
use App\Http\Requests\MassDestroyServicingContractRequest;

class ServicingContractController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingContracts = ServicingContract::latest()->paginate(10);

        return view('admin.servicingContracts.index', compact('servicingContracts'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('servicing_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        abort_if( ! $request->has('inhouse_installation_id') || $request->inhouse_installation_id == NULL || ! is_numeric($request->inhouse_installation_id), Response::HTTP_BAD_REQUEST, '400 Bad Request');

        $servicingContract = ServicingContract::where('inhouse_installation_id', $request->inhouse_installation_id)->first();
        abort_if($servicingContract, Response::HTTP_NOT_FOUND, '404 Not Found');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $project = Project::find($request->project_id);        

        return view('admin.servicingContracts.create', compact('projects', 'project'));
    }

    public function store(StoreServicingContractRequest $request)  //StoreServicingContractRequest
    {
        /**
         * Return 404 if there is no inhouse installation in database
         */
        $inHouseInstallation = InHouseInstallation::findOrFail($request->inhouse_installation_id);

        $servicingContract = ServicingContract::where('inhouse_installation_id', $request->inhouse_installation_id)->first();
        abort_if($servicingContract, Response::HTTP_BAD_REQUEST, '400 Bad Request');

        $contract_start_date = Carbon::parse($request->contract_start_date);
        $contract_end_date = Carbon::parse($request->contract_end_date);

        $differentInMonths = $contract_start_date->diffInMonths($contract_end_date);
        // dd($differentInMonths);
        $interval = $request->interval;

        $maintenanceTimes = floor($differentInMonths / $interval);
        
        $maintenanceStartDate = $contract_start_date->addMonths($interval)->format(config('panel.date_format'));

        $servicingContract = ServicingContract::create([
            'inhouse_installation_id' => $request->inhouse_installation_id,
            'project_id' => $request->project_id ?? NULL,
            'interval' => $interval,
            'contract_start_date' => $request->contract_start_date,
            'contract_end_date' => $request->contract_end_date,
            'created_by_id' => auth()->user()->id,
            'remark' => $request->remark,
        ]);

        $this->createServicingSetups($maintenanceStartDate, $maintenanceTimes, $request->all(), $servicingContract);

        return redirect()->route('admin.servicing-setups.index');
    }

    public function createServicingSetups($maintenanceStartDate, $maintenanceTimes, $request, $servicingContract) : void
    {
        $inHouseInstallation = InHouseInstallation::findOrFail($request['inhouse_installation_id']);

        $maintenanceDates[] = $maintenanceStartDate;

        for ($i = 0; $i < $maintenanceTimes - 1; $i++) {
            $maintenanceDates[] = Carbon::parse($maintenanceDates[$i])->addMonths($request['interval'])->format(config('panel.date_format'));
        }

        $team_type = $inHouseInstallation->sale_contract->installation_type == 'Both' ? 'both' : $inHouseInstallation->sale_contract->installation_type;

        for ($i = 0; $i < $maintenanceTimes; $i++) {
            $servicingSetup = ServicingSetup::create([
               'estimated_date' => $maintenanceDates[$i],
               'status' => NULL,
               'team_type' => $team_type,
               'request_type' => $request['request_type'],
               'created_by_id' => auth()->user()->id,
               'project_id' => $request['project_id'] ?? NULL,
            ]);
            $servicingSetup->attachMorph($servicingContract);
        }
    }

    public function showServicingSetup(Request $request)
    {
        $servicingSetup = ServicingSetup::where([
            'estimated_date' => $request->date,
            'project_id' => $request->project_id ?? NULL,
            'request_type' => config('servicingSetup.request_type_contract')
        ])->firstOrFail();

        return redirect()->route('admin.servicing-setups.show', $servicingSetup->id);
    }

    public function edit(ServicingContract $servicingContract)
    {
        abort_if(Gate::denies('servicing_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicingContract->load('project', 'created_by', 'updated_by');

        return view('admin.servicingContracts.edit', compact('projects', 'created_bies', 'updated_bies', 'servicingContract'));
    }

    public function update(UpdateServicingContractRequest $request, ServicingContract $servicingContract)
    {
        $servicingContract->update($request->all());

        return redirect()->route('admin.servicing-contracts.index');
    }

    public function show(ServicingContract $servicingContract)
    {
        abort_if(Gate::denies('servicing_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingContract->load('inhouse_installation', 'project', 'created_by', 'updated_by');

        return view('admin.servicingContracts.show', compact('servicingContract'));
    }

    public function destroy(ServicingContract $servicingContract)
    {
        abort_if(Gate::denies('servicing_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingContract->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicingContractRequest $request)
    {
        ServicingContract::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
