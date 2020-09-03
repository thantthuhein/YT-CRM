<?php

namespace App\Http\Requests;

use App\EquipmentDeliverySchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateEquipmentDeliveryScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('equipment_delivery_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'delivered_at' => ['date_format:' . config('panel.date_format'), 'required'],
            'description' => 'required',
        ];
    }
}
