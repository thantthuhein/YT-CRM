<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRepairTeamRequest;
use App\Http\Requests\StoreRepairTeamRequest;
use App\Http\Requests\UpdateRepairTeamRequest;
use App\RepairTeam;
use App\RepairTeamConnector;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairTeamController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('repair_team_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeams = RepairTeam::paginate(10);

        return view('admin.repairTeams.index', compact('repairTeams'));
    }

    public function create()
    {
        abort_if(Gate::denies('repair_team_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.repairTeams.create');
    }

    public function store(StoreRepairTeamRequest $request)
    {
        $userId = auth()->user()->id;
        
        $data = $request->all();
        $data['created_by_id'] = $userId;

        $repairTeam = RepairTeam::create($data);

        return redirect()->route('admin.repair-teams.index');
    }

    public function edit(RepairTeam $repairTeam)
    {
        abort_if(Gate::denies('repair_team_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $repairTeam->load('created_by', 'updated_by');

        return view('admin.repairTeams.edit', compact('created_bies', 'updated_bies', 'repairTeam'));
    }

    public function update(UpdateRepairTeamRequest $request, RepairTeam $repairTeam)
    {
        $repairTeam->update($request->all());

        return redirect()->route('admin.repair-teams.index');
    }

    public function show(RepairTeam $repairTeam)
    {
        abort_if(Gate::denies('repair_team_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $connectors = RepairTeamConnector::where('morphable_type', 'App\RepairTeam')->paginate(10);

        $repairTeam->load('created_by', 'updated_by');

        return view('admin.repairTeams.show', compact('repairTeam', 'connectors'));
    }

    public function destroy(RepairTeam $repairTeam)
    {
        abort_if(Gate::denies('repair_team_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repairTeam->delete();

        return back();
    }

    public function massDestroy(MassDestroyRepairTeamRequest $request)
    {
        RepairTeam::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
