<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWarrantyClaimRequest;
use App\Http\Requests\UpdateWarrantyClaimRequest;
use App\Http\Resources\Admin\WarrantyClaimResource;
use App\WarrantyClaim;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('warranty_claim_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimResource(WarrantyClaim::with(['oncall', 'warranty_claim_validation', 'warranty_claim_action', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreWarrantyClaimRequest $request)
    {
        $warrantyClaim = WarrantyClaim::create($request->all());

        if ($request->input('warranty_claim_pdf', false)) {
            $warrantyClaim->addMedia(storage_path('tmp/uploads/' . $request->input('warranty_claim_pdf')))->toMediaCollection('warranty_claim_pdf');
        }

        return (new WarrantyClaimResource($warrantyClaim))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimResource($warrantyClaim->load(['oncall', 'warranty_claim_validation', 'warranty_claim_action', 'created_by', 'updated_by']));
    }

    public function update(UpdateWarrantyClaimRequest $request, WarrantyClaim $warrantyClaim)
    {
        $warrantyClaim->update($request->all());

        if ($request->input('warranty_claim_pdf', false)) {
            if (!$warrantyClaim->warranty_claim_pdf || $request->input('warranty_claim_pdf') !== $warrantyClaim->warranty_claim_pdf->file_name) {
                $warrantyClaim->addMedia(storage_path('tmp/uploads/' . $request->input('warranty_claim_pdf')))->toMediaCollection('warranty_claim_pdf');
            }
        } elseif ($warrantyClaim->warranty_claim_pdf) {
            $warrantyClaim->warranty_claim_pdf->delete();
        }

        return (new WarrantyClaimResource($warrantyClaim))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaim->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
