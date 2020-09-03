<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubComInstallationRequest;
use App\Http\Requests\UpdateSubComInstallationRequest;
use App\Http\Resources\Admin\SubComInstallationResource;
use App\SubComInstallation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubComInstallationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_com_installation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubComInstallationResource(SubComInstallation::with(['sale_contract'])->get());
    }

    public function store(StoreSubComInstallationRequest $request)
    {
        $subComInstallation = SubComInstallation::create($request->all());

        return (new SubComInstallationResource($subComInstallation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubComInstallation $subComInstallation)
    {
        abort_if(Gate::denies('sub_com_installation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubComInstallationResource($subComInstallation->load(['sale_contract']));
    }

    public function update(UpdateSubComInstallationRequest $request, SubComInstallation $subComInstallation)
    {
        $subComInstallation->update($request->all());

        return (new SubComInstallationResource($subComInstallation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubComInstallation $subComInstallation)
    {
        abort_if(Gate::denies('sub_com_installation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComInstallation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
