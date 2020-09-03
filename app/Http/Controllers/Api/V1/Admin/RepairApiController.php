<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRepairRequest;
use App\Http\Requests\UpdateRepairRequest;
use App\Http\Resources\Admin\RepairResource;
use App\Repair;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepairApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('repair_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairResource(Repair::with(['oncall', 'created_by', 'updated_by'])->get());
    }

    public function store(StoreRepairRequest $request)
    {
        $repair = Repair::create($request->all());

        if ($request->input('service_report_pdf', false)) {
            $repair->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf')))->toMediaCollection('service_report_pdf');
        }

        return (new RepairResource($repair))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Repair $repair)
    {
        abort_if(Gate::denies('repair_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RepairResource($repair->load(['oncall', 'created_by', 'updated_by']));
    }

    public function update(UpdateRepairRequest $request, Repair $repair)
    {
        $repair->update($request->all());

        if ($request->input('service_report_pdf', false)) {
            if (!$repair->service_report_pdf || $request->input('service_report_pdf') !== $repair->service_report_pdf->file_name) {
                $repair->addMedia(storage_path('tmp/uploads/' . $request->input('service_report_pdf')))->toMediaCollection('service_report_pdf');
            }
        } elseif ($repair->service_report_pdf) {
            $repair->service_report_pdf->delete();
        }

        return (new RepairResource($repair))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Repair $repair)
    {
        abort_if(Gate::denies('repair_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
