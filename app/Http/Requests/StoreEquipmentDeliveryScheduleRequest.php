<?php

namespace App\Http\Requests;

use App\EquipmentDeliverySchedule;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreEquipmentDeliveryScheduleRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('equipment_delivery_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'description' => [
                'required',
                'array'
            ],
            'description.*' => [
                'required',
            ],
            'delivered_at'  => [
                'required',
                'array'
            ],
            'delivered_at.*' => [
                'required',
                'date_format:' . config('panel.date_format'),
            ],
        ];
    }

    public function messages()
    {
        return [
            'description.required' => 'Description field is required',
            'description.*' => 'Description field is required',
            'delivered_at.required' => 'Delivered At field is required',
            'delivered_at.*' => 'Delivered At field is required',
            'delivered_at.*.date_format' => 'Delivered At field is invalid',
        ];
    }
}
