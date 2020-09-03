<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWarrantyactionTeamConnectorRequest;
use App\Http\Requests\StoreWarrantyactionTeamConnectorRequest;
use App\Http\Requests\UpdateWarrantyactionTeamConnectorRequest;
use App\ServicingTeam;
use App\WarrantyactionTeamConnector;
use App\WarrantyClaimAction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyactionTeamConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warrantyaction_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyactionTeamConnectors = WarrantyactionTeamConnector::all();

        return view('admin.warrantyactionTeamConnectors.index', compact('warrantyactionTeamConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('warrantyaction_team_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warranty_actions = WarrantyClaimAction::all()->pluck('daikin_rep_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.warrantyactionTeamConnectors.create', compact('warranty_actions', 'servicing_teams'));
    }

    public function store(StoreWarrantyactionTeamConnectorRequest $request)
    {
        $warrantyactionTeamConnector = WarrantyactionTeamConnector::create($request->all());

        return redirect()->route('admin.warrantyaction-team-connectors.index');
    }

    public function edit(WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        abort_if(Gate::denies('warrantyaction_team_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warranty_actions = WarrantyClaimAction::all()->pluck('daikin_rep_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warrantyactionTeamConnector->load('warranty_action', 'servicing_team');

        return view('admin.warrantyactionTeamConnectors.edit', compact('warranty_actions', 'servicing_teams', 'warrantyactionTeamConnector'));
    }

    public function update(UpdateWarrantyactionTeamConnectorRequest $request, WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        $warrantyactionTeamConnector->update($request->all());

        return redirect()->route('admin.warrantyaction-team-connectors.index');
    }

    public function show(WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        abort_if(Gate::denies('warrantyaction_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyactionTeamConnector->load('warranty_action', 'servicing_team');

        return view('admin.warrantyactionTeamConnectors.show', compact('warrantyactionTeamConnector'));
    }

    public function destroy(WarrantyactionTeamConnector $warrantyactionTeamConnector)
    {
        abort_if(Gate::denies('warrantyaction_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyactionTeamConnector->delete();

        return back();
    }

    public function massDestroy(MassDestroyWarrantyactionTeamConnectorRequest $request)
    {
        WarrantyactionTeamConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
