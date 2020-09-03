<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWarrantyClaimActionRequest;
use App\Http\Requests\UpdateWarrantyClaimActionRequest;
use App\Http\Resources\Admin\WarrantyClaimActionResource;
use App\WarrantyClaimAction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WarrantyClaimActionApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('warranty_claim_action_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimActionResource(WarrantyClaimAction::with(['created_by', 'updated_by'])->get());
    }

    public function store(StoreWarrantyClaimActionRequest $request)
    {
        $warrantyClaimAction = WarrantyClaimAction::create($request->all());

        if ($request->input('service_report_pdf_ywar_taw', false)) {
            $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf_ywar_taw')))->toMediaCollection('service_report_pdf_ywar_taw');
        }

        if ($request->input('service_report_pdf_daikin', false)) {
            $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf_daikin')))->toMediaCollection('service_report_pdf_daikin');
        }

        if ($request->input('deliver_order_pdf', false)) {
            $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('deliver_order_pdf')))->toMediaCollection('deliver_order_pdf');
        }

        return (new WarrantyClaimActionResource($warrantyClaimAction))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(WarrantyClaimAction $warrantyClaimAction)
    {
        abort_if(Gate::denies('warranty_claim_action_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new WarrantyClaimActionResource($warrantyClaimAction->load(['created_by', 'updated_by']));
    }

    public function update(UpdateWarrantyClaimActionRequest $request, WarrantyClaimAction $warrantyClaimAction)
    {
        $warrantyClaimAction->update($request->all());

        if ($request->input('service_report_pdf_ywar_taw', false)) {
            if (!$warrantyClaimAction->service_report_pdf_ywar_taw || $request->input('service_report_pdf_ywar_taw') !== $warrantyClaimAction->service_report_pdf_ywar_taw->file_name) {
                $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf_ywar_taw')))->toMediaCollection('service_report_pdf_ywar_taw');
            }
        } elseif ($warrantyClaimAction->service_report_pdf_ywar_taw) {
            $warrantyClaimAction->service_report_pdf_ywar_taw->delete();
        }

        if ($request->input('service_report_pdf_daikin', false)) {
            if (!$warrantyClaimAction->service_report_pdf_daikin || $request->input('service_report_pdf_daikin') !== $warrantyClaimAction->service_report_pdf_daikin->file_name) {
                $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf_daikin')))->toMediaCollection('service_report_pdf_daikin');
            }
        } elseif ($warrantyClaimAction->service_report_pdf_daikin) {
            $warrantyClaimAction->service_report_pdf_daikin->delete();
        }

        if ($request->input('deliver_order_pdf', false)) {
            if (!$warrantyClaimAction->deliver_order_pdf || $request->input('deliver_order_pdf') !== $warrantyClaimAction->deliver_order_pdf->file_name) {
                $warrantyClaimAction->addMedia(storage_path('tmp/uploads/' . $request->input('deliver_order_pdf')))->toMediaCollection('deliver_order_pdf');
            }
        } elseif ($warrantyClaimAction->deliver_order_pdf) {
            $warrantyClaimAction->deliver_order_pdf->delete();
        }

        return (new WarrantyClaimActionResource($warrantyClaimAction))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(WarrantyClaimAction $warrantyClaimAction)
    {
        abort_if(Gate::denies('warranty_claim_action_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimAction->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
