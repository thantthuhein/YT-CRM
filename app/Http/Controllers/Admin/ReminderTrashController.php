<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReminderTrashRequest;
use App\Http\Requests\StoreReminderTrashRequest;
use App\Http\Requests\UpdateReminderTrashRequest;
use App\Reminder;
use App\ReminderTrash;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReminderTrashController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reminder_trash_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminderTrashes = ReminderTrash::all();

        return view('admin.reminderTrashes.index', compact('reminderTrashes'));
    }

    public function create()
    {
        abort_if(Gate::denies('reminder_trash_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminders = Reminder::all()->pluck('remindable', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.reminderTrashes.create', compact('reminders'));
    }

    public function store(StoreReminderTrashRequest $request)
    {
        $reminderTrash = ReminderTrash::create($request->all());

        return redirect()->route('admin.reminder-trashes.index');
    }

    public function edit(ReminderTrash $reminderTrash)
    {
        abort_if(Gate::denies('reminder_trash_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminders = Reminder::all()->pluck('remindable', 'id')->prepend(trans('global.pleaseSelect'), '');

        $reminderTrash->load('reminder');

        return view('admin.reminderTrashes.edit', compact('reminders', 'reminderTrash'));
    }

    public function update(UpdateReminderTrashRequest $request, ReminderTrash $reminderTrash)
    {
        $reminderTrash->update($request->all());

        return redirect()->route('admin.reminder-trashes.index');
    }

    public function show(ReminderTrash $reminderTrash)
    {
        abort_if(Gate::denies('reminder_trash_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminderTrash->load('reminder');

        return view('admin.reminderTrashes.show', compact('reminderTrash'));
    }

    public function destroy(ReminderTrash $reminderTrash)
    {
        abort_if(Gate::denies('reminder_trash_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reminderTrash->delete();

        return back();
    }

    public function massDestroy(MassDestroyReminderTrashRequest $request)
    {
        ReminderTrash::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
