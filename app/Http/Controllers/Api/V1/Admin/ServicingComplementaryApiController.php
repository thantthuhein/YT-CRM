<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicingComplementaryRequest;
use App\Http\Requests\UpdateServicingComplementaryRequest;
use App\Http\Resources\Admin\ServicingComplementaryResource;
use App\ServicingComplementary;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingComplementaryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_complementary_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingComplementaryResource(ServicingComplementary::with(['inhouse_installation', 'project', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreServicingComplementaryRequest $request)
    {
        $servicingComplementary = ServicingComplementary::create($request->all());

        return (new ServicingComplementaryResource($servicingComplementary))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingComplementary $servicingComplementary)
    {
        abort_if(Gate::denies('servicing_complementary_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingComplementaryResource($servicingComplementary->load(['inhouse_installation', 'project', 'created_by', 'updated_by']));
    }

    public function update(UpdateServicingComplementaryRequest $request, ServicingComplementary $servicingComplementary)
    {
        $servicingComplementary->update($request->all());

        return (new ServicingComplementaryResource($servicingComplementary))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingComplementary $servicingComplementary)
    {
        abort_if(Gate::denies('servicing_complementary_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingComplementary->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
