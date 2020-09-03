<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReminderTrashRequest;
use App\Http\Requests\UpdateReminderTrashRequest;
use App\Http\Resources\Admin\ReminderTrashResource;
use App\ReminderTrash;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReminderTrashApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reminder_trash_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReminderTrashResource(ReminderTrash::with(['reminder'])->get());
    }

    public function store(StoreReminderTrashRequest $request)
    {
        $reminderTrash = ReminderTrash::create($request->all());

        return (new ReminderTrashResource($reminderTrash))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReminderTrash $reminderTrash)
    {
        abort_if(Gate::denies('reminder_trash_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReminderTrashResource($reminderTrash->load(['reminder']));
    }

    public function update(UpdateReminderTrashRequest $request, ReminderTrash $reminderTrash)
    {
        $reminderTrash->update($request->all());

        return (new ReminderTrashResource($reminderTrash))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReminderTrash $reminderTrash)
    {
        abort_if(Gate::denies('reminder_trash_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminderTrash->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
