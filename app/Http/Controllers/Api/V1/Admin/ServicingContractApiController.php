<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServicingContractRequest;
use App\Http\Requests\UpdateServicingContractRequest;
use App\Http\Resources\Admin\ServicingContractResource;
use App\ServicingContract;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingContractApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingContractResource(ServicingContract::with(['project', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreServicingContractRequest $request)
    {
        $servicingContract = ServicingContract::create($request->all());

        return (new ServicingContractResource($servicingContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingContract $servicingContract)
    {
        abort_if(Gate::denies('servicing_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingContractResource($servicingContract->load(['project', 'created_by', 'updated_by']));
    }

    public function update(UpdateServicingContractRequest $request, ServicingContract $servicingContract)
    {
        $servicingContract->update($request->all());

        return (new ServicingContractResource($servicingContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingContract $servicingContract)
    {
        abort_if(Gate::denies('servicing_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingContract->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
