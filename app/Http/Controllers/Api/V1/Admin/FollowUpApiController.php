<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\FollowUp;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use App\Http\Resources\Admin\FollowUpResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowUpApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follow_up_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowUpResource(FollowUp::with(['quotation_revision', 'user'])->get());
    }

    public function store(StoreFollowUpRequest $request)
    {
        $followUp = FollowUp::create($request->all());

        return (new FollowUpResource($followUp))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FollowUp $followUp)
    {
        abort_if(Gate::denies('follow_up_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FollowUpResource($followUp->load(['quotation_revision', 'user']));
    }

    public function update(UpdateFollowUpRequest $request, FollowUp $followUp)
    {
        $followUp->update($request->all());

        return (new FollowUpResource($followUp))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FollowUp $followUp)
    {
        abort_if(Gate::denies('follow_up_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followUp->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
