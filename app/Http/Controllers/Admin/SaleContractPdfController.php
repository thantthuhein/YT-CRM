<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroySaleContractPdfRequest;
use App\Http\Requests\StoreSaleContractPdfRequest;
use App\Http\Requests\UpdateSaleContractPdfRequest;
use App\SaleContract;
use App\SaleContractPdf;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleContractPdfController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('sale_contract_pdf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContractPdfs = SaleContractPdf::all();

        return view('admin.saleContractPdfs.index', compact('saleContractPdfs'));
    }

    public function create()
    {
        abort_if(Gate::denies('sale_contract_pdf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $uploaded_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.saleContractPdfs.create', compact('sale_contracts', 'uploaded_bies'));
    }

    public function store(StoreSaleContractPdfRequest $request)
    {
        $saleContractPdf = SaleContractPdf::create($request->all());

        if ($request->input('url', false)) {
            $saleContractPdf->addMedia(storage_path('tmp/uploads/' . $request->input('url')))->toMediaCollection('url');
        }

        return redirect()->route('admin.sale-contract-pdfs.index');
    }

    public function edit(SaleContractPdf $saleContractPdf)
    {
        abort_if(Gate::denies('sale_contract_pdf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $uploaded_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saleContractPdf->load('sale_contract', 'uploaded_by');

        return view('admin.saleContractPdfs.edit', compact('sale_contracts', 'uploaded_bies', 'saleContractPdf'));
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

        return redirect()->route('admin.sale-contract-pdfs.index');
    }

    public function show(SaleContractPdf $saleContractPdf)
    {
        abort_if(Gate::denies('sale_contract_pdf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContractPdf->load('sale_contract', 'uploaded_by');

        return view('admin.saleContractPdfs.show', compact('saleContractPdf'));
    }

    public function destroy(SaleContractPdf $saleContractPdf)
    {
        abort_if(Gate::denies('sale_contract_pdf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContractPdf->delete();

        return back();
    }

    public function massDestroy(MassDestroySaleContractPdfRequest $request)
    {
        SaleContractPdf::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
