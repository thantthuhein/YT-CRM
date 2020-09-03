<?php

namespace App\Http\Requests;

use App\ReminderTrash;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReminderTrashRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reminder_trash_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reminder_trashes,id',
        ];
    }
}
