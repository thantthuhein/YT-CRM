<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicingTeamRequest;
use App\Http\Requests\UpdateServicingTeamRequest;
use App\Http\Resources\Admin\ServicingTeamResource;
use App\ServicingTeam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingTeamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingTeamResource(ServicingTeam::with(['created_by', 'updated_by'])->get());
    }

    public function store(StoreServicingTeamRequest $request)
    {
        $servicingTeam = ServicingTeam::create($request->all());

        return (new ServicingTeamResource($servicingTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingTeam $servicingTeam)
    {
        abort_if(Gate::denies('servicing_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingTeamResource($servicingTeam->load(['created_by', 'updated_by']));
    }

    public function update(UpdateServicingTeamRequest $request, ServicingTeam $servicingTeam)
    {
        $servicingTeam->update($request->all());

        return (new ServicingTeamResource($servicingTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingTeam $servicingTeam)
    {
        abort_if(Gate::denies('servicing_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
