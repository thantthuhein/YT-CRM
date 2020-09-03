<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreInHouseInstallationRequest;
use App\Http\Requests\UpdateInHouseInstallationRequest;
use App\Http\Resources\Admin\InHouseInstallationResource;
use App\InHouseInstallation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class InHouseInstallationApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('in_house_installation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InHouseInstallationResource(InHouseInstallation::with(['sale_engineer', 'sale_contract', 'approved_service_manager', 'approved_project_manager'])->get());
    }

    public function store(StoreInHouseInstallationRequest $request)
    {
        $inHouseInstallation = InHouseInstallation::create($request->all());

        if ($request->input('actual_installation_report_pdf', false)) {
            $inHouseInstallation->addMedia(storage_path('tmp/uploads/' . $request->input('actual_installation_report_pdf')))->toMediaCollection('actual_installation_report_pdf');
        }

        return (new InHouseInstallationResource($inHouseInstallation))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('in_house_installation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new InHouseInstallationResource($inHouseInstallation->load(['sale_engineer', 'sale_contract', 'approved_service_manager', 'approved_project_manager']));
    }

    public function update(UpdateInHouseInstallationRequest $request, InHouseInstallation $inHouseInstallation)
    {
        $inHouseInstallation->update($request->all());

        if ($request->input('actual_installation_report_pdf', false)) {
            if (!$inHouseInstallation->actual_installation_report_pdf || $request->input('actual_installation_report_pdf') !== $inHouseInstallation->actual_installation_report_pdf->file_name) {
                $inHouseInstallation->addMedia(storage_path('tmp/uploads/' . $request->input('actual_installation_report_pdf')))->toMediaCollection('actual_installation_report_pdf');
            }
        } elseif ($inHouseInstallation->actual_installation_report_pdf) {
            $inHouseInstallation->actual_installation_report_pdf->delete();
        }

        return (new InHouseInstallationResource($inHouseInstallation))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('in_house_installation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inHouseInstallation->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    function getCompletedInstallationsByMonth()
    {
        $calendarMonths = collect(config('calendarMonths'));

        
    }
}
