<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInhouseInstallationTeamRequest;
use App\Http\Requests\StoreInhouseInstallationTeamRequest;
use App\Http\Requests\UpdateInhouseInstallationTeamRequest;
use App\InHouseInstallation;
use App\InhouseInstallationTeam;
use App\ServicingTeam;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InhouseInstallationTeamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('inhouse_installation_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouseInstallationTeams = InhouseInstallationTeam::paginate(10);

        return view('admin.inhouseInstallationTeams.index', compact('inhouseInstallationTeams'));
    }

    public function create()
    {
        abort_if(Gate::denies('inhouse_installation_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.inhouseInstallationTeams.create', compact('servicing_teams', 'inhouse_installations', 'created_bies', 'updated_bies'));
    }

    public function store(StoreInhouseInstallationTeamRequest $request)
    {
        $inhouseInstallationTeam = InhouseInstallationTeam::create($request->all());

        return redirect()->route('admin.inhouse-installation-teams.index');
    }

    public function edit(InhouseInstallationTeam $inhouseInstallationTeam)
    {
        abort_if(Gate::denies('inhouse_installation_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $inhouseInstallationTeam->load('servicing_team', 'inhouse_installation', 'created_by', 'updated_by');

        return view('admin.inhouseInstallationTeams.edit', compact('servicing_teams', 'inhouse_installations', 'created_bies', 'updated_bies', 'inhouseInstallationTeam'));
    }

    public function update(UpdateInhouseInstallationTeamRequest $request, InhouseInstallationTeam $inhouseInstallationTeam)
    {
        $inhouseInstallationTeam->update($request->all());

        return redirect()->route('admin.inhouse-installation-teams.index');
    }

    public function show(InhouseInstallationTeam $inhouseInstallationTeam)
    {
        abort_if(Gate::denies('inhouse_installation_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouseInstallationTeam->load('servicing_team', 'inhouse_installation', 'created_by', 'updated_by');

        return view('admin.inhouseInstallationTeams.show', compact('inhouseInstallationTeam'));
    }

    public function destroy(InhouseInstallationTeam $inhouseInstallationTeam)
    {
        abort_if(Gate::denies('inhouse_installation_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouseInstallationTeam->delete();

        return back();
    }

    public function massDestroy(MassDestroyInhouseInstallationTeamRequest $request)
    {
        InhouseInstallationTeam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
