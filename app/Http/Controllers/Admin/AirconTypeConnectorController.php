<?php

namespace App\Http\Controllers\Admin;

use App\AirconType;
use App\AirconTypeConnector;
use App\Enquiry;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAirconTypeConnectorRequest;
use App\Http\Requests\StoreAirconTypeConnectorRequest;
use App\Http\Requests\UpdateAirconTypeConnectorRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AirconTypeConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('aircon_type_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypeConnectors = AirconTypeConnector::all();

        return view('admin.airconTypeConnectors.index', compact('airconTypeConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('aircon_type_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiries = Enquiry::all()->pluck('location', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aircon_types = AirconType::all()->pluck('type', 'id');

        return view('admin.airconTypeConnectors.create', compact('enquiries', 'aircon_types'));
    }

    public function store(StoreAirconTypeConnectorRequest $request)
    {
        $airconTypeConnector = AirconTypeConnector::create($request->all());
        $airconTypeConnector->aircon_types()->sync($request->input('aircon_types', []));

        return redirect()->route('admin.aircon-type-connectors.index');
    }

    public function edit(AirconTypeConnector $airconTypeConnector)
    {
        abort_if(Gate::denies('aircon_type_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiries = Enquiry::all()->pluck('location', 'id')->prepend(trans('global.pleaseSelect'), '');

        $aircon_types = AirconType::all()->pluck('type', 'id');

        $airconTypeConnector->load('enquiries', 'aircon_types');

        return view('admin.airconTypeConnectors.edit', compact('enquiries', 'aircon_types', 'airconTypeConnector'));
    }

    public function update(UpdateAirconTypeConnectorRequest $request, AirconTypeConnector $airconTypeConnector)
    {
        $airconTypeConnector->update($request->all());
        $airconTypeConnector->aircon_types()->sync($request->input('aircon_types', []));

        return redirect()->route('admin.aircon-type-connectors.index');
    }

    public function show(AirconTypeConnector $airconTypeConnector)
    {
        abort_if(Gate::denies('aircon_type_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypeConnector->load('enquiries', 'aircon_types');

        return view('admin.airconTypeConnectors.show', compact('airconTypeConnector'));
    }

    public function destroy(AirconTypeConnector $airconTypeConnector)
    {
        abort_if(Gate::denies('aircon_type_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypeConnector->delete();

        return back();
    }

    public function massDestroy(MassDestroyAirconTypeConnectorRequest $request)
    {
        AirconTypeConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
