<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicingTeamRequest;
use App\Http\Requests\StoreServicingTeamRequest;
use App\Http\Requests\UpdateServicingTeamRequest;
use App\ServicingTeam;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ServicingTeamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeams = ServicingTeam::paginate(10);

        return view('admin.servicingTeams.index', compact('servicingTeams'));
    }

    public function create()
    {
        abort_if(Gate::denies('servicing_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servicingTeams.create', compact('created_bies', 'updated_bies'));
    }

    public function store(StoreServicingTeamRequest $request)
    {
        $datas = $request->all();
        $datas['created_by_id'] = Auth::id();

        $servicingTeam = ServicingTeam::create($datas);

        return redirect()->route('admin.servicing-teams.index');
    }

    public function edit(ServicingTeam $servicingTeam)
    {
        abort_if(Gate::denies('servicing_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicingTeam->load('created_by', 'updated_by');

        return view('admin.servicingTeams.edit', compact('created_bies', 'updated_bies', 'servicingTeam'));
    }

    public function update(UpdateServicingTeamRequest $request, ServicingTeam $servicingTeam)
    {
        $servicingTeam->update($request->all());

        return redirect()->route('admin.servicing-teams.index');
    }

    public function show(ServicingTeam $servicingTeam)
    {
        abort_if(Gate::denies('servicing_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeam->load('created_by', 'updated_by');

        $teams = $servicingTeam->inhouseInstallationTeams()->whereHas('inhouse_installation')
        ->paginate(10);

        return view('admin.servicingTeams.show', compact('servicingTeam', 'teams'));
    }

    public function destroy(ServicingTeam $servicingTeam)
    {
        abort_if(Gate::denies('servicing_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingTeam->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicingTeamRequest $request)
    {
        ServicingTeam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
