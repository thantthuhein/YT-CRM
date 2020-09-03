<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreServicingSetupRequest;
use App\Http\Requests\UpdateServicingSetupRequest;
use App\Http\Resources\Admin\ServicingSetupResource;
use App\ServicingSetup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingSetupApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('servicing_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingSetupResource(ServicingSetup::with(['project', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreServicingSetupRequest $request)
    {
        $servicingSetup = ServicingSetup::create($request->all());

        if ($request->input('service_report_pdf', false)) {
            $servicingSetup->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf')))->toMediaCollection('service_report_pdf');
        }

        return (new ServicingSetupResource($servicingSetup))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ServicingSetup $servicingSetup)
    {
        abort_if(Gate::denies('servicing_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ServicingSetupResource($servicingSetup->load(['project', 'created_by', 'updated_by']));
    }

    public function update(UpdateServicingSetupRequest $request, ServicingSetup $servicingSetup)
    {
        $servicingSetup->update($request->all());

        if ($request->input('service_report_pdf', false)) {
            if (!$servicingSetup->service_report_pdf || $request->input('service_report_pdf') !== $servicingSetup->service_report_pdf->file_name) {
                $servicingSetup->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf')))->toMediaCollection('service_report_pdf');
            }
        } elseif ($servicingSetup->service_report_pdf) {
            $servicingSetup->service_report_pdf->delete();
        }

        return (new ServicingSetupResource($servicingSetup))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ServicingSetup $servicingSetup)
    {
        abort_if(Gate::denies('servicing_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetup->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
