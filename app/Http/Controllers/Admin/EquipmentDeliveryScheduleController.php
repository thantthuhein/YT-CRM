<?php

namespace App\Http\Controllers\Admin;

use App\EquipmentDeliverySchedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEquipmentDeliveryScheduleRequest;
use App\Http\Requests\StoreEquipmentDeliveryScheduleRequest;
use App\Http\Requests\UpdateEquipmentDeliveryScheduleRequest;
use App\SaleContract;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EquipmentDeliveryScheduleController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('equipment_delivery_schedule_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipmentDeliverySchedules = EquipmentDeliverySchedule::all();

        return view('admin.equipmentDeliverySchedules.index', compact('equipmentDeliverySchedules'));
    }

    public function create()
    {
        abort_if(Gate::denies('equipment_delivery_schedule_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.equipmentDeliverySchedules.create', compact('sale_contracts', 'created_bies', 'updated_bies'));
    }

    public function store(StoreEquipmentDeliveryScheduleRequest $request)
    {
        $equipmentDeliverySchedule = EquipmentDeliverySchedule::create($request->all());

        return redirect()->route('admin.equipment-delivery-schedules.index');
    }

    public function edit(EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        abort_if(Gate::denies('equipment_delivery_schedule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $equipmentDeliverySchedule->load('sale_contract', 'created_by', 'updated_by');

        return view('admin.equipmentDeliverySchedules.edit', compact('sale_contracts', 'created_bies', 'updated_bies', 'equipmentDeliverySchedule'));
    }

    public function update(UpdateEquipmentDeliveryScheduleRequest $request, EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        $equipmentDeliverySchedule->update($request->all());

        return redirect()->route('admin.sale-contracts.show', $equipmentDeliverySchedule->sale_contract->id);
    }

    public function show(EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        abort_if(Gate::denies('equipment_delivery_schedule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipmentDeliverySchedule->load('sale_contract', 'created_by', 'updated_by');

        return view('admin.equipmentDeliverySchedules.show', compact('equipmentDeliverySchedule'));
    }

    public function destroy(EquipmentDeliverySchedule $equipmentDeliverySchedule)
    {
        abort_if(Gate::denies('equipment_delivery_schedule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $equipmentDeliverySchedule->delete();

        return back();
    }

    public function massDestroy(MassDestroyEquipmentDeliveryScheduleRequest $request)
    {
        EquipmentDeliverySchedule::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
