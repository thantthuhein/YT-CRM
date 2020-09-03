<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyQuotationRevisionRequest;
use App\Http\Requests\StoreQuotationRevisionRequest;
use App\Http\Requests\UpdateQuotationRevisionRequest;
use App\Quotation;
use App\QuotationRevision;
use App\Services\QuotationRevisionService;
use Illuminate\Validation\Rule;
use App\User;
use App\Traits\ImageUploadTrait;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QuotationRevisionController extends Controller
{
    use MediaUploadingTrait, ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('quotation_revision_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotationRevisions = QuotationRevision::all();

        return view('admin.quotationRevisions.index', compact('quotationRevisions'));
    }

    public function create($quotation_id)
    {
        // dd($quotation_id);
        abort_if(Gate::denies('quotation_revision_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation = Quotation::with('quotationRevisions')->findOrFail($quotation_id);
        
        // $quotations = Quotation::with('quotationRevisions')->pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.quotationRevisions.create', compact('quotation', 'created_bies', 'updated_bies'));
    }

    public function store(StoreQuotationRevisionRequest $request)
    {
        (new QuotationRevisionService)->createQuotationRevision($request->all());

        if ($request->quotation_pdf === false) {
            $quotationRevision->addMedia(storage_path('tmp/uploads/' . $request->input('quotation_pdf')))->toMediaCollection('quotation_pdf');
        }

        return redirect()->route('admin.quotations.show',[$request['quotation_id']]);
    }

    public function edit(QuotationRevision $quotationRevision)
    {
        abort_if(Gate::denies('quotation_revision_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotations = Quotation::all()->pluck('number', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quotationRevision->load('quotation', 'created_by', 'updated_by');

        return view('admin.quotationRevisions.edit', compact('quotations', 'created_bies', 'updated_bies', 'quotationRevision'));
    }

    public function update(UpdateQuotationRevisionRequest $request, QuotationRevision $quotationRevision)
    {
        $title = "Q_" . $quotationRevision->quotation->id . "_R_" . $quotationRevision->id;
        $quotation_pdf = static::storeFileToBucket($title, $request->quotation_pdf);

        $quotationRevision->update([
            'quoted_date' => $request->quoted_date,
            'status' => $request->status,
            'quotation_pdf' => $quotation_pdf
        ]);

        // if ($request->input('quotation_pdf', false)) {
        //     if (!$quotationRevision->quotation_pdf || $request->input('quotation_pdf') !== $quotationRevision->quotation_pdf->file_name) {
        //         $quotationRevision->addMedia(storage_path('tmp/uploads/' . $request->input('quotation_pdf')))->toMediaCollection('quotation_pdf');
        //     }
        // } elseif ($quotationRevision->quotation_pdf) {
        //     $quotationRevision->quotation_pdf->delete();
        // }

        $quotationRevision->quotation()->update([
            'status' => $request->status
        ]);

        return redirect()->route('admin.quotations.show', $quotationRevision->quotation->id);
        
    }

    public function show(QuotationRevision $quotationRevision)
    {
        abort_if(Gate::denies('quotation_revision_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotationRevision->load('quotation', 'created_by', 'updated_by');

        return view('admin.quotationRevisions.show', compact('quotationRevision'));
    }

    public function destroy(QuotationRevision $quotationRevision)
    {
        abort_if(Gate::denies('quotation_revision_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotationRevision->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuotationRevisionRequest $request)
    {
        QuotationRevision::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function view_pdf($id)
    {
        $quotationRevision = QuotationRevision::where('id', $id)->first();

        return view('admin.quotationRevisions.view_pdf', ['quotationRevision' => $quotationRevision]);
    }

    public function download_pdf($id)
    {
        $quotationRevision = QuotationRevision::find($id);
        // dd($quotationRevision->quotation_pdf);
        return response($quotationRevision->quotation_pdf)
        ->header('Content-Type', 'application/pdf');
    }

}
