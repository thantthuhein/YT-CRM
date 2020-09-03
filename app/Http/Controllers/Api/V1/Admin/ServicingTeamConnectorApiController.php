<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicingTeamConnectorRequest;
use App\Http\Requests\UpdateServicingTeamConnectorRequest;
use App\Http\Resources\Admin\ServicingTeamConnectorResource;
use App\ServicingTeamConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingTeamConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingTeamConnectorResource(ServicingTeamConnector::with(['servicing_setup'])->get());
    }

    public function store(StoreServicingTeamConnectorRequest $request)
    {
        $servicingTeamConnector = ServicingTeamConnector::create($request->all());

        return (new ServicingTeamConnectorResource($servicingTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingTeamConnector $servicingTeamConnector)
    {
        abort_if(Gate::denies('servicing_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingTeamConnectorResource($servicingTeamConnector->load(['servicing_setup']));
    }

    public function update(UpdateServicingTeamConnectorRequest $request, ServicingTeamConnector $servicingTeamConnector)
    {
        $servicingTeamConnector->update($request->all());

        return (new ServicingTeamConnectorResource($servicingTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingTeamConnector $servicingTeamConnector)
    {
        abort_if(Gate::denies('servicing_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeamConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
