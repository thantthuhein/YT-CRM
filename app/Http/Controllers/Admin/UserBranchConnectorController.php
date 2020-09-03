<?php

namespace App\Http\Controllers\Admin;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserBranchConnectorRequest;
use App\Http\Requests\StoreUserBranchConnectorRequest;
use App\Http\Requests\UpdateUserBranchConnectorRequest;
use App\UserBranchConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBranchConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_branch_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBranchConnectors = UserBranchConnector::all();

        return view('admin.userBranchConnectors.index', compact('userBranchConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_branch_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = Branch::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $branches = Branch::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.userBranchConnectors.create', compact('users', 'branches'));
    }

    public function store(StoreUserBranchConnectorRequest $request)
    {
        $userBranchConnector = UserBranchConnector::create($request->all());

        return redirect()->route('admin.user-branch-connectors.index');
    }

    public function edit(UserBranchConnector $userBranchConnector)
    {
        abort_if(Gate::denies('user_branch_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = Branch::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $branches = Branch::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $userBranchConnector->load('user', 'branch');

        return view('admin.userBranchConnectors.edit', compact('users', 'branches', 'userBranchConnector'));
    }

    public function update(UpdateUserBranchConnectorRequest $request, UserBranchConnector $userBranchConnector)
    {
        $userBranchConnector->update($request->all());

        return redirect()->route('admin.user-branch-connectors.index');
    }

    public function show(UserBranchConnector $userBranchConnector)
    {
        abort_if(Gate::denies('user_branch_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBranchConnector->load('user', 'branch');

        return view('admin.userBranchConnectors.show', compact('userBranchConnector'));
    }

    public function destroy(UserBranchConnector $userBranchConnector)
    {
        abort_if(Gate::denies('user_branch_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBranchConnector->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserBranchConnectorRequest $request)
    {
        UserBranchConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
