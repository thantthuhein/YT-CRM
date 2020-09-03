<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use App\Http\Resources\Admin\QuotationResource;
use App\Quotation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuotationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuotationResource(Quotation::with(['customer', 'enquiries', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreQuotationRequest $request)
    {
        $quotation = Quotation::create($request->all());

        return (new QuotationResource($quotation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuotationResource($quotation->load(['customer', 'enquiries', 'created_by', 'updated_by']));
    }

    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $quotation->update($request->all());

        return (new QuotationResource($quotation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function searchQuotation(Request $request)
    {
        return Quotation::search($request)->get();
    }

}
