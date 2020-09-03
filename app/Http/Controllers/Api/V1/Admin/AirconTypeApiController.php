<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\AirconType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAirconTypeRequest;
use App\Http\Requests\UpdateAirconTypeRequest;
use App\Http\Resources\Admin\AirconTypeResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AirconTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('aircon_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AirconTypeResource(AirconType::all());
    }

    public function store(StoreAirconTypeRequest $request)
    {
        $airconType = AirconType::create($request->all());

        return (new AirconTypeResource($airconType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AirconType $airconType)
    {
        abort_if(Gate::denies('aircon_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AirconTypeResource($airconType);
    }

    public function update(UpdateAirconTypeRequest $request, AirconType $airconType)
    {
        $airconType->update($request->all());

        return (new AirconTypeResource($airconType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AirconType $airconType)
    {
        abort_if(Gate::denies('aircon_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
