<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreSaleContractPdfRequest;
use App\Http\Requests\UpdateSaleContractPdfRequest;
use App\Http\Resources\Admin\SaleContractPdfResource;
use App\SaleContractPdf;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleContractPdfApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('sale_contract_pdf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaleContractPdfResource(SaleContractPdf::with(['sale_contract', 'uploaded_by'])->get());
    }

    public function store(StoreSaleContractPdfRequest $request)
    {
        $saleContractPdf = SaleContractPdf::create($request->all());

        if ($request->input('url', false)) {
            $saleContractPdf->addMedia(storage_path('tmp/uploads/' . $request->input('url')))->toMediaCollection('url');
        }

        return (new SaleContractPdfResource($saleContractPdf))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SaleContractPdf $saleContractPdf)
    {
        abort_if(Gate::denies('sale_contract_pdf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaleContractPdfResource($saleContractPdf->load(['sale_contract', 'uploaded_by']));
    }

    public function update(UpdateSaleContractPdfRequest $request, SaleContractPdf $saleContractPdf)
    {
        $saleContractPdf->update($request->all());

        if ($request->input('url', false)) {
            if (!$saleContractPdf->url || $request->input('url') !== $saleContractPdf->url->file_name) {
                $saleContractPdf->addMedia(storage_path('tmp/uploads/' . $request->input('url')))->toMediaCollection('url');
            }
        } elseif ($saleContractPdf->url) {
            $saleContractPdf->url->delete();
        }

        return (new SaleContractPdfResource($saleContractPdf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SaleContractPdf $saleContractPdf)
    {
        abort_if(Gate::denies('sale_contract_pdf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContractPdf->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
