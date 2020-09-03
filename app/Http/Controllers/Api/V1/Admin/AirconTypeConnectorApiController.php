<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AirconTypeConnector;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirconTypeConnectorRequest;
use App\Http\Requests\UpdateAirconTypeConnectorRequest;
use App\Http\Resources\Admin\AirconTypeConnectorResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AirconTypeConnectorApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('aircon_type_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AirconTypeConnectorResource(AirconTypeConnector::with(['enquiries', 'aircon_types'])->get());
    }

    public function store(StoreAirconTypeConnectorRequest $request)
    {
        $airconTypeConnector = AirconTypeConnector::create($request->all());
        $airconTypeConnector->aircon_types()->sync($request->input('aircon_types', []));

        return (new AirconTypeConnectorResource($airconTypeConnector))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AirconTypeConnector $airconTypeConnector)
    {
        abort_if(Gate::denies('aircon_type_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AirconTypeConnectorResource($airconTypeConnector->load(['enquiries', 'aircon_types']));
    }

    public function update(UpdateAirconTypeConnectorRequest $request, AirconTypeConnector $airconTypeConnector)
    {
        $airconTypeConnector->update($request->all());
        $airconTypeConnector->aircon_types()->sync($request->input('aircon_types', []));

        return (new AirconTypeConnectorResource($airconTypeConnector))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AirconTypeConnector $airconTypeConnector)
    {
        abort_if(Gate::denies('aircon_type_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypeConnector->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
