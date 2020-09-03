<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInhouseInstallationTeamRequest;
use App\Http\Requests\UpdateInhouseInstallationTeamRequest;
use App\Http\Resources\Admin\InhouseInstallationTeamResource;
use App\InhouseInstallationTeam;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InhouseInstallationTeamApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('inhouse_installation_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InhouseInstallationTeamResource(InhouseInstallationTeam::with(['servicing_team', 'inhouse_installation', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreInhouseInstallationTeamRequest $request)
    {
        $inhouseInstallationTeam = InhouseInstallationTeam::create($request->all());

        return (new InhouseInstallationTeamResource($inhouseInstallationTeam))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(InhouseInstallationTeam $inhouseInstallationTeam)
    {
        abort_if(Gate::denies('inhouse_installation_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InhouseInstallationTeamResource($inhouseInstallationTeam->load(['servicing_team', 'inhouse_installation', 'created_by', 'updated_by']));
    }

    public function update(UpdateInhouseInstallationTeamRequest $request, InhouseInstallationTeam $inhouseInstallationTeam)
    {
        $inhouseInstallationTeam->update($request->all());

        return (new InhouseInstallationTeamResource($inhouseInstallationTeam))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(InhouseInstallationTeam $inhouseInstallationTeam)
    {
        abort_if(Gate::denies('inhouse_installation_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouseInstallationTeam->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
