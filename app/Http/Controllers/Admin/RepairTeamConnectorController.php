<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRepairTeamConnectorRequest;
use App\Http\Requests\StoreRepairTeamConnectorRequest;
use App\Http\Requests\UpdateRepairTeamConnectorRequest;
use App\Repair;
use App\RepairTeamConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairTeamConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeamConnectors = RepairTeamConnector::all();

        return view('admin.repairTeamConnectors.index', compact('repairTeamConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_team_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairs = Repair::all()->pluck('estimate_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.repairTeamConnectors.create', compact('repairs'));
    }

    public function store(StoreRepairTeamConnectorRequest $request)
    {
        $repairTeamConnector = RepairTeamConnector::create($request->all());

        return redirect()->route('admin.repair-team-connectors.index');
    }

    public function edit(RepairTeamConnector $repairTeamConnector)
    {
        abort_if(Gate::denies('repair_team_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairs = Repair::all()->pluck('estimate_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $repairTeamConnector->load('repair');

        return view('admin.repairTeamConnectors.edit', compact('repairs', 'repairTeamConnector'));
    }

    public function update(UpdateRepairTeamConnectorRequest $request, RepairTeamConnector $repairTeamConnector)
    {
        $repairTeamConnector->update($request->all());

        return redirect()->route('admin.repair-team-connectors.index');
    }

    public function show(RepairTeamConnector $repairTeamConnector)
    {
        abort_if(Gate::denies('repair_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeamConnector->load('repair');

        return view('admin.repairTeamConnectors.show', compact('repairTeamConnector'));
    }

    public function destroy(RepairTeamConnector $repairTeamConnector)
    {
        abort_if(Gate::denies('repair_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeamConnector->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairTeamConnectorRequest $request)
    {
        RepairTeamConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
