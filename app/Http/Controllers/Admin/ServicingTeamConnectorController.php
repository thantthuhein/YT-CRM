<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicingTeamConnectorRequest;
use App\Http\Requests\StoreServicingTeamConnectorRequest;
use App\Http\Requests\UpdateServicingTeamConnectorRequest;
use App\ServicingSetup;
use App\ServicingTeamConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingTeamConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeamConnectors = ServicingTeamConnector::all();

        return view('admin.servicingTeamConnectors.index', compact('servicingTeamConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('servicing_team_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_setups = ServicingSetup::all()->pluck('is_major', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servicingTeamConnectors.create', compact('servicing_setups'));
    }

    public function store(StoreServicingTeamConnectorRequest $request)
    {
        $servicingTeamConnector = ServicingTeamConnector::create($request->all());

        return redirect()->route('admin.servicing-team-connectors.index');
    }

    public function edit(ServicingTeamConnector $servicingTeamConnector)
    {
        abort_if(Gate::denies('servicing_team_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_setups = ServicingSetup::all()->pluck('is_major', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicingTeamConnector->load('servicing_setup');

        return view('admin.servicingTeamConnectors.edit', compact('servicing_setups', 'servicingTeamConnector'));
    }

    public function update(UpdateServicingTeamConnectorRequest $request, ServicingTeamConnector $servicingTeamConnector)
    {
        $servicingTeamConnector->update($request->all());

        return redirect()->route('admin.servicing-team-connectors.index');
    }

    public function show(ServicingTeamConnector $servicingTeamConnector)
    {
        abort_if(Gate::denies('servicing_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeamConnector->load('servicing_setup');

        return view('admin.servicingTeamConnectors.show', compact('servicingTeamConnector'));
    }

    public function destroy(ServicingTeamConnector $servicingTeamConnector)
    {
        abort_if(Gate::denies('servicing_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeamConnector->delete();

        return redirect()->back();
    }

    public function massDestroy(MassDestroyServicingTeamConnectorRequest $request)
    {
        ServicingTeamConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
