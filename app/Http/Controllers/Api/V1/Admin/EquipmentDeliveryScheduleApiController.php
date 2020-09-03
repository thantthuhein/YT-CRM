<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\EquipmentDeliverySchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEquipmentDeliveryScheduleRequest;
use App\Http\Requests\UpdateEquipmentDeliveryScheduleRequest;
use App\Http\Resources\Admin\EquipmentDeliveryScheduleResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EquipmentDeliveryScheduleApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('equipment_delivery_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EquipmentDeliveryScheduleResource(EquipmentDeliverySchedule::with(['sale_contract', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreEquipmentDeliveryScheduleRequest $request)
    {
        $equipmentDeliverySchedule = EquipmentDeliverySchedule::create($request->all());

        return (new EquipmentDeliveryScheduleResource($equipmentDeliverySchedule))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        abort_if(Gate::denies('equipment_delivery_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EquipmentDeliveryScheduleResource($equipmentDeliverySchedule->load(['sale_contract', 'created_by', 'updated_by']));
    }

    public function update(UpdateEquipmentDeliveryScheduleRequest $request, EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        $equipmentDeliverySchedule->update($request->all());

        return (new EquipmentDeliveryScheduleResource($equipmentDeliverySchedule))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        abort_if(Gate::denies('equipment_delivery_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipmentDeliverySchedule->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
