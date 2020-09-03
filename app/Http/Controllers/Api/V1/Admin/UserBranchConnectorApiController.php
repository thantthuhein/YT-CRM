<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserBranchConnectorRequest;
use App\Http\Requests\UpdateUserBranchConnectorRequest;
use App\Http\Resources\Admin\UserBranchConnectorResource;
use App\UserBranchConnector;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserBranchConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_branch_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserBranchConnectorResource(UserBranchConnector::with(['user', 'branch'])->get());
    }

    public function store(StoreUserBranchConnectorRequest $request)
    {
        $userBranchConnector = UserBranchConnector::create($request->all());

        return (new UserBranchConnectorResource($userBranchConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(UserBranchConnector $userBranchConnector)
    {
        abort_if(Gate::denies('user_branch_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new UserBranchConnectorResource($userBranchConnector->load(['user', 'branch']));
    }

    public function update(UpdateUserBranchConnectorRequest $request, UserBranchConnector $userBranchConnector)
    {
        $userBranchConnector->update($request->all());

        return (new UserBranchConnectorResource($userBranchConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(UserBranchConnector $userBranchConnector)
    {
        abort_if(Gate::denies('user_branch_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userBranchConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
