<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepairTeamConnectorRequest;
use App\Http\Requests\UpdateRepairTeamConnectorRequest;
use App\Http\Resources\Admin\RepairTeamConnectorResource;
use App\RepairTeamConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairTeamConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_team_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairTeamConnectorResource(RepairTeamConnector::with(['repair'])->get());
    }

    public function store(StoreRepairTeamConnectorRequest $request)
    {
        $repairTeamConnector = RepairTeamConnector::create($request->all());

        return (new RepairTeamConnectorResource($repairTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RepairTeamConnector $repairTeamConnector)
    {
        abort_if(Gate::denies('repair_team_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairTeamConnectorResource($repairTeamConnector->load(['repair']));
    }

    public function update(UpdateRepairTeamConnectorRequest $request, RepairTeamConnector $repairTeamConnector)
    {
        $repairTeamConnector->update($request->all());

        return (new RepairTeamConnectorResource($repairTeamConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RepairTeamConnector $repairTeamConnector)
    {
        abort_if(Gate::denies('repair_team_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeamConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
