<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOnCallRequest;
use App\Http\Requests\UpdateOnCallRequest;
use App\Http\Resources\Admin\OnCallResource;
use App\OnCall;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OnCallApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('on_call_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OnCallResource(OnCall::with(['project', 'service_type', 'customer', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreOnCallRequest $request)
    {
        $onCall = OnCall::create($request->all());

        return (new OnCallResource($onCall))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(OnCall $onCall)
    {
        abort_if(Gate::denies('on_call_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OnCallResource($onCall->load(['project', 'service_type', 'customer', 'created_by', 'updated_by']));
    }

    public function update(UpdateOnCallRequest $request, OnCall $onCall)
    {
        $onCall->update($request->all());

        return (new OnCallResource($onCall))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(OnCall $onCall)
    {
        abort_if(Gate::denies('on_call_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onCall->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
