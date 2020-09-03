<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRepairTeamRequest;
use App\Http\Requests\UpdateRepairTeamRequest;
use App\Http\Resources\Admin\RepairTeamResource;
use App\RepairTeam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairTeamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairTeamResource(RepairTeam::with(['created_by', 'updated_by'])->get());
    }

    public function store(StoreRepairTeamRequest $request)
    {
        $repairTeam = RepairTeam::create($request->all());

        return (new RepairTeamResource($repairTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RepairTeam $repairTeam)
    {
        abort_if(Gate::denies('repair_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairTeamResource($repairTeam->load(['created_by', 'updated_by']));
    }

    public function update(UpdateRepairTeamRequest $request, RepairTeam $repairTeam)
    {
        $repairTeam->update($request->all());

        return (new RepairTeamResource($repairTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RepairTeam $repairTeam)
    {
        abort_if(Gate::denies('repair_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
