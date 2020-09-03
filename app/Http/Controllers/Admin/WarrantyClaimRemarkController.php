<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWarrantyClaimRemarkRequest;
use App\Http\Requests\StoreWarrantyClaimRemarkRequest;
use App\Http\Requests\UpdateWarrantyClaimRemarkRequest;
use App\WarrantyClaim;
use App\WarrantyClaimRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimRemarkController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warranty_claim_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimRemarks = WarrantyClaimRemark::all();

        return view('admin.warrantyClaimRemarks.index', compact('warrantyClaimRemarks'));
    }

    public function create()
    {
        abort_if(Gate::denies('warranty_claim_remark_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warranty_claims = WarrantyClaim::all()->pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.warrantyClaimRemarks.create', compact('warranty_claims'));
    }

    public function store(StoreWarrantyClaimRemarkRequest $request)
    {
        $warrantyClaimRemark = WarrantyClaimRemark::create($request->all());

        return redirect()->route('admin.warranty-claim-remarks.index');
    }

    public function edit(WarrantyClaimRemark $warrantyClaimRemark)
    {
        abort_if(Gate::denies('warranty_claim_remark_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warranty_claims = WarrantyClaim::all()->pluck('status', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warrantyClaimRemark->load('warranty_claim');

        return view('admin.warrantyClaimRemarks.edit', compact('warranty_claims', 'warrantyClaimRemark'));
    }

    public function update(UpdateWarrantyClaimRemarkRequest $request, WarrantyClaimRemark $warrantyClaimRemark)
    {
        $warrantyClaimRemark->update($request->all());

        return redirect()->route('admin.warranty-claim-remarks.index');
    }

    public function show(WarrantyClaimRemark $warrantyClaimRemark)
    {
        abort_if(Gate::denies('warranty_claim_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimRemark->load('warranty_claim');

        return view('admin.warrantyClaimRemarks.show', compact('warrantyClaimRemark'));
    }

    public function destroy(WarrantyClaimRemark $warrantyClaimRemark)
    {
        abort_if(Gate::denies('warranty_claim_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimRemark->delete();

        return back();
    }

    public function massDestroy(MassDestroyWarrantyClaimRemarkRequest $request)
    {
        WarrantyClaimRemark::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
