<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreQuotationRevisionRequest;
use App\Http\Requests\UpdateQuotationRevisionRequest;
use App\Http\Resources\Admin\QuotationRevisionResource;
use App\QuotationRevision;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuotationRevisionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('quotation_revision_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuotationRevisionResource(QuotationRevision::with(['quotation', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreQuotationRevisionRequest $request)
    {
        $quotationRevision = QuotationRevision::create($request->all());

        if ($request->input('quotation_pdf', false)) {
            $quotationRevision->addMedia(storage_path('tmp/uploads/' . $request->input('quotation_pdf')))->toMediaCollection('quotation_pdf');
        }

        return (new QuotationRevisionResource($quotationRevision))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(QuotationRevision $quotationRevision)
    {
        abort_if(Gate::denies('quotation_revision_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new QuotationRevisionResource($quotationRevision->load(['quotation', 'created_by', 'updated_by']));
    }

    public function update(UpdateQuotationRevisionRequest $request, QuotationRevision $quotationRevision)
    {
        $quotationRevision->update($request->all());

        if ($request->input('quotation_pdf', false)) {
            if (!$quotationRevision->quotation_pdf || $request->input('quotation_pdf') !== $quotationRevision->quotation_pdf->file_name) {
                $quotationRevision->addMedia(storage_path('tmp/uploads/' . $request->input('quotation_pdf')))->toMediaCollection('quotation_pdf');
            }
        } elseif ($quotationRevision->quotation_pdf) {
            $quotationRevision->quotation_pdf->delete();
        }

        return (new QuotationRevisionResource($quotationRevision))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(QuotationRevision $quotationRevision)
    {
        abort_if(Gate::denies('quotation_revision_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotationRevision->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
