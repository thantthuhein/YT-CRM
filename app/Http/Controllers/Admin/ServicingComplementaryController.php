<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicingComplementaryRequest;
use App\Http\Requests\StoreServicingComplementaryRequest;
use App\Http\Requests\UpdateServicingComplementaryRequest;
use App\InHouseInstallation;
use App\Project;
use App\ServicingComplementary;
use App\User;
use App\ServicingSetup;
use Carbon\Carbon;
use App\Customer;
use App\SaleContract;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingComplementaryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_complementary_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingComplementaries = ServicingComplementary::latest()->paginate(10);

        return view('admin.servicingComplementaries.index', compact('servicingComplementaries'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('servicing_complementary_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
          
        $sale_contract = SaleContract::findOrFail($request->sale_contract_id);

        $sale_contract->load('inHouseInstallation');

        return view('admin.servicingComplementaries.create', compact('sale_contract'));
    }

    public function store(StoreServicingComplementaryRequest $request) //StoreServicingComplementaryRequest
    {
        $inHouseInstallation = InHouseInstallation::findOrFail($request->inhouse_installation_id);
        $tc_time = $inHouseInstallation->tc_time;

        $first_maintenance_date = Carbon::parse($tc_time)->addMonths(6)->format(config('panel.date_format'));
        $second_maintenance_date = Carbon::parse($tc_time)->addMonths(12)->format(config('panel.date_format'));

        if ( ! $inHouseInstallation->servicingComplementaries->isEmpty() ) {
            abort(403);
        }

        $servicingComplementary = ServicingComplementary::create([
            'first_maintenance_date' => $first_maintenance_date,
            'second_maintenance_date' => $second_maintenance_date,
            'inhouse_installation_id' => $request->inhouse_installation_id,
            'project_id' => $request->project_id,
            'created_by_id' => auth()->user()->id,
        ]);

        $this->createServicingSetups($first_maintenance_date, $second_maintenance_date, $request->all(), $servicingComplementary);

        return redirect()->back();
    }

    public function createServicingSetups($first_maintenance_date, $second_maintenance_date, $request, $servicingComplementary) : void
    {
        $inHouseInstallation = InHouseInstallation::findOrFail($request['inhouse_installation_id']);

        $team_type = $inHouseInstallation->sale_contract->installation_type == "Both" ? 'both' : $inHouseInstallation->sale_contract->installation_type;

        $firstMaintenance = ServicingSetup::create([
           'estimated_date' => $first_maintenance_date,
           'status' => NULL,
           'request_type' => $request['request_type'],
           'team_type' => $team_type,
           'created_by_id' => auth()->user()->id,
           'project_id' => $request['project_id'],
        ]);
        $firstMaintenance->attachMorph($servicingComplementary);

        $secondMaintenance = ServicingSetup::create([
           'estimated_date' => $second_maintenance_date,
           'status' => NULL,
           'request_type' => $request['request_type'],
           'team_type' => $team_type,
           'created_by_id' => auth()->user()->id,
           'project_id' => $request['project_id'],
        ]);
        $secondMaintenance->attachMorph($servicingComplementary);
    }

    public function showServicingSetup(Request $request)
    {
        $servicingSetup = ServicingSetup::where([
            'estimated_date' => $request->date,
            'project_id' => $request->project_id,
            'request_type' => config('servicingSetup.request_type_complementary')
        ])->firstOrFail();

        return redirect()->route('admin.servicing-setups.show', $servicingSetup->id);
    }

    public function edit(ServicingComplementary $servicingComplementary)
    {
        abort_if(Gate::denies('servicing_complementary_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicingComplementary->load('inhouse_installation', 'project', 'created_by', 'updated_by');

        return view('admin.servicingComplementaries.edit', compact('inhouse_installations', 'projects', 'created_bies', 'updated_bies', 'servicingComplementary'));
    }

    public function update(UpdateServicingComplementaryRequest $request, ServicingComplementary $servicingComplementary)
    {
        $servicingComplementary->update($request->all());

        return redirect()->route('admin.servicing-complementaries.index');
    }

    public function show(ServicingComplementary $servicingComplementary)
    {
        abort_if(Gate::denies('servicing_complementary_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingComplementary->load('inhouse_installation', 'project', 'created_by', 'updated_by');

        return view('admin.servicingComplementaries.show', compact('servicingComplementary'));
    }

    public function destroy(ServicingComplementary $servicingComplementary)
    {
        abort_if(Gate::denies('servicing_complementary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingComplementary->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicingComplementaryRequest $request)
    {
        ServicingComplementary::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
