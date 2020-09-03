<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubCompanyRequest;
use App\Http\Requests\UpdateSubCompanyRequest;
use App\Http\Resources\Admin\SubCompanyResource;
use App\SubCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCompanyApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubCompanyResource(SubCompany::with(['created_by', 'updated_by'])->get());
    }

    public function store(StoreSubCompanyRequest $request)
    {
        $subCompany = SubCompany::create($request->all());

        return (new SubCompanyResource($subCompany))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SubCompanyResource($subCompany->load(['created_by', 'updated_by']));
    }

    public function update(UpdateSubCompanyRequest $request, SubCompany $subCompany)
    {
        $subCompany->update($request->all());

        return (new SubCompanyResource($subCompany))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompany->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
