<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\InHouseInstallation;
use Illuminate\Http\Request;
use App\MaterialDeliveryPdfs;
use App\MaterialDeliveryProgress;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreMaterialDeliveryProgressRequest;
use App\Http\Requests\UpdateMaterialDeliveryProgressRequest;
use App\Http\Requests\MassDestroyMaterialDeliveryProgressRequest;
use App\Traits\ImageUploadTrait;

class MaterialDeliveryProgressController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('material_delivery_progress_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialDeliveryProgresses = MaterialDeliveryProgress::all();

        return view('admin.materialDeliveryProgresses.index', compact('materialDeliveryProgresses'));
    }

    public function create()
    {
        abort_if(Gate::denies('material_delivery_progress_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $inhouse_installations = InHouseInstallation::all()->pluck('estimate_start_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $last_updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.materialDeliveryProgresses.create', compact('inhouse_installations', 'created_bies', 'last_updated_bies'));
    }

    public function store(StoreMaterialDeliveryProgressRequest $request)
    {
        $materialDeliveryProgress = MaterialDeliveryProgress::create($request->all());

        return redirect()->route('admin.material-delivery-progresses.index');
    }

    public function edit(MaterialDeliveryProgress $materialDeliveryProgress)
    {
        abort_if(Gate::denies('material_delivery_progress_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialDeliveryProgress->load('inhouse_installation', 'created_by', 'last_updated_by');

        return view('admin.materialDeliveryProgresses.edit', compact('materialDeliveryProgress'));
    }

    public function update(UpdateMaterialDeliveryProgressRequest $request, MaterialDeliveryProgress $materialDeliveryProgress)
    {
        $userId = auth()->user()->id;

        if($request->has('remove')){
            $request->validate([
                'material_pdf' => 'required|array',
                'material_pdf.*' => 'required|mimes:pdf|max:'.config('panel.pdf_max_size'),
            ]);
            $materialDeliveryProgress->material_delivery_pdfs()->delete();
        }

        $updatedData = $request->all();

        /**
         * check and update status
         */
        // $maxProgress = $materialDeliveryProgress->max_progress;

        // if($updatedData['progress'] == 100 && $updatedData['progress'] > $maxProgress )
        // {
            
        // }

        $updatedData['last_updated_by_id'] = $userId;

        $materialDeliveryProgress->update($updatedData);
        

        if($request->has('material_pdf'))
        {
            $folder = config('bucket.material_delivery_pdf');

            foreach($updatedData['material_pdf'] as $pdf){
                $url = $this->storeFileToBucket(null, $pdf, $folder);

                MaterialDeliveryPdfs::create([
                    'material_delivery_progress_id' => $materialDeliveryProgress->id,
                    'pdf' => $url
                ]);
            }
        }

        return redirect()->route('admin.in-house-installations.show', [$materialDeliveryProgress->inhouse_installation]);
    }

    public function show(MaterialDeliveryProgress $materialDeliveryProgress)
    {
        abort_if(Gate::denies('material_delivery_progress_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialDeliveryProgress->load('inhouse_installation', 'created_by', 'last_updated_by');

        return view('admin.materialDeliveryProgresses.show', compact('materialDeliveryProgress'));
    }

    public function destroy(MaterialDeliveryProgress $materialDeliveryProgress)
    {
        abort_if(Gate::denies('material_delivery_progress_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $materialDeliveryProgress->delete();

        return back();
    }

    public function massDestroy(MassDestroyMaterialDeliveryProgressRequest $request)
    {
        MaterialDeliveryProgress::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
