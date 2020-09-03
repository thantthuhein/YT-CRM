<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\HandOverPdf;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreHandOverPdfRequest;
use App\Http\Requests\UpdateHandOverPdfRequest;
use App\Http\Resources\Admin\HandOverPdfResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandOverPdfApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('hand_over_pdf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HandOverPdfResource(HandOverPdf::with(['inhouse_installation'])->get());
    }

    public function store(StoreHandOverPdfRequest $request)
    {
        $handOverPdf = HandOverPdf::create($request->all());

        if ($request->input('url', false)) {
            $handOverPdf->addMedia(storage_path('tmp/uploads/' . $request->input('url')))->toMediaCollection('url');
        }

        return (new HandOverPdfResource($handOverPdf))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(HandOverPdf $handOverPdf)
    {
        abort_if(Gate::denies('hand_over_pdf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new HandOverPdfResource($handOverPdf->load(['inhouse_installation']));
    }

    public function update(UpdateHandOverPdfRequest $request, HandOverPdf $handOverPdf)
    {
        $handOverPdf->update($request->all());

        if ($request->input('url', false)) {
            if (!$handOverPdf->url || $request->input('url') !== $handOverPdf->url->file_name) {
                $handOverPdf->addMedia(storage_path('tmp/uploads/' . $request->input('url')))->toMediaCollection('url');
            }
        } elseif ($handOverPdf->url) {
            $handOverPdf->url->delete();
        }

        return (new HandOverPdfResource($handOverPdf))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(HandOverPdf $handOverPdf)
    {
        abort_if(Gate::denies('hand_over_pdf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $handOverPdf->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
