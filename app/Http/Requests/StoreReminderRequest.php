<?php

namespace App\Http\Requests;

use App\Reminder;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreReminderRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reminder_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'remindable' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
