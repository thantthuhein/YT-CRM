<?php

namespace App\Http\Controllers\Admin;

use App\AirconType;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAirconTypeRequest;
use App\Http\Requests\StoreAirconTypeRequest;
use App\Http\Requests\UpdateAirconTypeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AirconTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('aircon_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypes = AirconType::all();

        return view('admin.airconTypes.index', compact('airconTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('aircon_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.airconTypes.create');
    }

    public function store(StoreAirconTypeRequest $request)
    {
        $airconType = AirconType::create($request->all());

        return redirect()->route('admin.aircon-types.index');
    }

    public function edit(AirconType $airconType)
    {
        abort_if(Gate::denies('aircon_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.airconTypes.edit', compact('airconType'));
    }

    public function update(UpdateAirconTypeRequest $request, AirconType $airconType)
    {
        $airconType->update($request->all());

        return redirect()->route('admin.aircon-types.index');
    }

    public function show(AirconType $airconType)
    {
        abort_if(Gate::denies('aircon_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.airconTypes.show', compact('airconType'));
    }

    public function destroy(AirconType $airconType)
    {
        abort_if(Gate::denies('aircon_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconType->delete();

        return back();
    }

    public function massDestroy(MassDestroyAirconTypeRequest $request)
    {
        AirconType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
