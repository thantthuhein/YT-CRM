<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarrantyClaimValidationRequest;
use App\Http\Requests\UpdateWarrantyClaimValidationRequest;
use App\Http\Resources\Admin\WarrantyClaimValidationResource;
use App\WarrantyClaimValidation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimValidationApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('warranty_claim_validation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimValidationResource(WarrantyClaimValidation::with(['repair_team', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreWarrantyClaimValidationRequest $request)
    {
        $warrantyClaimValidation = WarrantyClaimValidation::create($request->all());

        return (new WarrantyClaimValidationResource($warrantyClaimValidation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WarrantyClaimValidation $warrantyClaimValidation)
    {
        abort_if(Gate::denies('warranty_claim_validation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimValidationResource($warrantyClaimValidation->load(['repair_team', 'created_by', 'updated_by']));
    }

    public function update(UpdateWarrantyClaimValidationRequest $request, WarrantyClaimValidation $warrantyClaimValidation)
    {
        $warrantyClaimValidation->update($request->all());

        return (new WarrantyClaimValidationResource($warrantyClaimValidation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WarrantyClaimValidation $warrantyClaimValidation)
    {
        abort_if(Gate::denies('warranty_claim_validation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimValidation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
