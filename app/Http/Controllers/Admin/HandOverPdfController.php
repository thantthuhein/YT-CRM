<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\HandOverPdf;
use App\HandOverChecklist;
use App\InHouseInstallation;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHandOverPdfRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\UpdateHandOverPdfRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyHandOverPdfRequest;
use App\Jobs\CompletingInstallationNecessaryDocsJob;

class HandOverPdfController extends Controller
{
    use MediaUploadingTrait, ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('hand_over_pdf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $handOverPdfs = HandOverPdf::all();

        return view('admin.handOverPdfs.index', compact('handOverPdfs'));
    }

    public function create(InHouseInstallation $inHouseInstallation)
    {
        abort_if(Gate::denies('hand_over_pdf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $handoverPdfTypes = config('pdfTypes.sale_contract.handover_pdfs');

        $checklists = $inHouseInstallation->handOverChecklists->groupBy('type');

        return view('admin.handOverPdfs.create', compact('inHouseInstallation', 'handoverPdfTypes', 'checklists'));
    }

    public function store(Request $request, InHouseInstallation $inHouseInstallation)
    {
        if ($request->has('handover_pdfs')) {
            $handoverPdfs = $request->handover_pdfs;

            $this->storeHandoverFiles($handoverPdfs, $inHouseInstallation);

            dispatch(new CompletingInstallationNecessaryDocsJob($inHouseInstallation));
        }

        return redirect()->route('admin.in-house-installations.show', [$inHouseInstallation])->withSuccess('Upload Success!');
    }

    public function storeHandoverFiles($handoverPdfs, $inHouseInstallation)
    {

        $handoverFolder = config("bucket.sale_contract") . config("bucket.handover_pdf");
        $handoverPdfTypes = config('pdfTypes.sale_contract.handover_pdfs');

        foreach ($handoverPdfs as $key => $pdf) {
            $pdfTitle = $handoverPdfTypes[$key];
            $now = date('Y-m-d', time());

            if (is_array($pdf)) {
                foreach ($pdf as $subPdf) {
                    $pdfUrl = $this->storeFileToBucket($pdfTitle, $subPdf, $handoverFolder);

                    HandOverPdf::create([
                        'file_type' => $key,
                        'inhouse_installation_id' => $inHouseInstallation->id,
                        'url' => $pdfUrl
                    ]);
                }
            } else {
                $existingFile = $inHouseInstallation->handOverPdfs()->uploadedFile($key)->first();
                $pdfUrl = $this->storeFileToBucket($pdfTitle, $pdf, $handoverFolder);
                
                if($existingFile){
                    $existingFile->url = $pdfUrl;
                    $existingFile->update();
                }
                else{
                    HandOverPdf::create([
                        'file_type' => $key,
                        'inhouse_installation_id' => $inHouseInstallation->id,
                        'url' => $pdfUrl
                    ]);
                }
            }
            /**
             * set uploaded_at to checklist
             */
            if (count($inHouseInstallation->handOverChecklists) != 5) {
                /**
                 * Create handover checklist
                 */

                foreach ($handoverPdfTypes as $typekey => $type) {

                    if($key == $typekey){
                        $uploaded_at = $now;
                    }
                    else{
                        $uploaded_at = null;
                    }
                    
                    HandOverChecklist::create([
                        'type' => $typekey,
                        'in_house_installation_id' => $inHouseInstallation->id,
                        'uploaded_at' => $uploaded_at
                    ]);
                }
            } else {
                if ($checklist = $inHouseInstallation->handOverChecklists->where('type', $key)->first()) {
                    $checklist->uploaded_at = $now;
                    $checklist->update();
                }
            }
        }
    }

    public function edit(HandOverPdf $handOverPdf)
    {
        abort_if(Gate::denies('hand_over_pdf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $handOverPdf->load('inhouse_installation');

        return view('admin.handOverPdfs.edit', compact('inhouse_installations', 'handOverPdf'));
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

        return redirect()->route('admin.hand-over-pdfs.index');
    }

    public function show(HandOverPdf $handOverPdf)
    {
        abort_if(Gate::denies('hand_over_pdf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $handOverPdf->load('inhouse_installation');

        return view('admin.handOverPdfs.show', compact('handOverPdf'));
    }

    public function destroy(HandOverPdf $handOverPdf)
    {
        abort_if(Gate::denies('hand_over_pdf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $handOverPdf->delete();

        return back();
    }

    public function massDestroy(MassDestroyHandOverPdfRequest $request)
    {
        HandOverPdf::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
