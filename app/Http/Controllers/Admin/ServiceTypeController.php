<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServiceTypeRequest;
use App\Http\Requests\StoreServiceTypeRequest;
use App\Http\Requests\UpdateServiceTypeRequest;
use App\ServiceType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('service_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceTypes = ServiceType::all();

        return view('admin.serviceTypes.index', compact('serviceTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('service_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceTypes.create');
    }

    public function store(StoreServiceTypeRequest $request)
    {
        $serviceType = ServiceType::create($request->all());

        return redirect()->route('admin.service-types.index');
    }

    public function edit(ServiceType $serviceType)
    {
        abort_if(Gate::denies('service_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceTypes.edit', compact('serviceType'));
    }

    public function update(UpdateServiceTypeRequest $request, ServiceType $serviceType)
    {
        $serviceType->update($request->all());

        return redirect()->route('admin.service-types.index');
    }

    public function show(ServiceType $serviceType)
    {
        abort_if(Gate::denies('service_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.serviceTypes.show', compact('serviceType'));
    }

    public function destroy(ServiceType $serviceType)
    {
        abort_if(Gate::denies('service_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $serviceType->delete();

        return back();
    }

    public function massDestroy(MassDestroyServiceTypeRequest $request)
    {
        ServiceType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
