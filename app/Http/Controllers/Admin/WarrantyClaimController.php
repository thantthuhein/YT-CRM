<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\OnCall;
use Carbon\Carbon;
use App\RepairTeam;
use App\ServicingTeam;
use App\WarrantyClaim;
use App\WarrantyClaimAction;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\WarrantyClaimValidation;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreWarrantyClaimRequest;
use App\Http\Requests\UpdateWarrantyClaimRequest;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyWarrantyClaimRequest;
use App\Jobs\CompletingWarrantyClaimFormJob;

class WarrantyClaimController extends Controller
{
    use MediaUploadingTrait, ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('warranty_claim_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaims = WarrantyClaim::latest()->paginate(10);

        return view('admin.warrantyClaims.index', compact('warrantyClaims'));
    }

    public function create()
    {
        abort_if(Gate::denies('warranty_claim_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $oncalls = OnCall::all()->pluck('is_new_customer', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warranty_claim_validations = WarrantyClaimValidation::all()->pluck('actual_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warranty_claim_actions = WarrantyClaimAction::all()->pluck('daikin_rep_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.warrantyClaims.create', compact('oncalls', 'warranty_claim_validations', 'warranty_claim_actions', 'created_bies', 'updated_bies'));
    }

    public function store(StoreWarrantyClaimRequest $request)
    {
        $warrantyClaim = WarrantyClaim::create($request->all());

        if ($request->input('warranty_claim_pdf', false)) {
            $warrantyClaim->addMedia(storage_path('tmp/uploads/' . $request->input('warranty_claim_pdf')))->toMediaCollection('warranty_claim_pdf');
        }

        return redirect()->route('admin.warranty-claims.index');
    }

    public function edit(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $oncalls = OnCall::all()->pluck('is_new_customer', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warranty_claim_validations = WarrantyClaimValidation::all()->pluck('actual_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warranty_claim_actions = WarrantyClaimAction::all()->pluck('daikin_rep_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warrantyClaim->load('oncall', 'warranty_claim_validation', 'warranty_claim_action', 'created_by', 'updated_by');

        return view('admin.warrantyClaims.edit', compact('oncalls', 'warranty_claim_validations', 'warranty_claim_actions', 'created_bies', 'updated_bies', 'warrantyClaim'));
    }

    public function update(UpdateWarrantyClaimRequest $request, WarrantyClaim $warrantyClaim)
    {
        $userId = auth()->user()->id;
        $data = $request->all();
        $data['updated_by_id'] = $userId;

        if($request->status == 'accepted') {
            $data['approved_at'] = Carbon::now();
        } elseif ($request->status == 'rejected') {
            $data['approved_at'] = NULL;
        }

        if ($request->status != 'pending') {
            $warrantyClaim->oncall->status = config('status.oncall.ongoing');    
            $warrantyClaim->push();
        } else {
            $warrantyClaim->oncall->status = config('status.oncall.pending');    
            $warrantyClaim->push();
        }
        
        $warrantyClaim->update($data);

        return redirect()->route('admin.warranty-claims.show', [$warrantyClaim]);
    }

    public function show(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaim->load('oncall', 'warranty_claim_validation', 'warranty_claim_action', 'created_by', 'updated_by');        

        $servicingTeams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend('Please Select', '');

        $repair_teams = RepairTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $currentStages = $warrantyClaim->getCurrentStages();        

        if ($warrantyClaim->warranty_claim_action) {
            // don't run unnecessary queries if oncall status is complete
            if ($warrantyClaim->oncall->status !== config('status.oncall.complete')) {
                $this->cosiderOncallStatus($warrantyClaim);
            }
        }

        return view('admin.warrantyClaims.show', compact('warrantyClaim', 'repair_teams', 'servicingTeams', 'currentStages'));
    }

    public function destroy(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaim->delete();

        return back();
    }

    public function massDestroy(MassDestroyWarrantyClaimRequest $request)
    {
        WarrantyClaim::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function uploadPdf(WarrantyClaim $warrantyClaim,Request $request){
        $userId = auth()->user()->id;
        $data = $request->validate([
            'warranty_claim_pdf' => 'required|mimes:pdf|max:'.config('panel.pdf_max_size')
        ]);

        $data['updated_by_id'] = $userId;

        if($request->hasFile('warranty_claim_pdf')){
            $title = $warrantyClaim->id. "_warranty_claim_pdf";
            $folder = config('bucket.warranty_claim');

            $url = $this->storeFileToBucket($title, $request->warranty_claim_pdf, $folder);

            $data['warranty_claim_pdf'] = $url;
            $data['status'] = 'pending';

            $warrantyClaim->update($data);

            $warrantyClaim->oncall->status = config('status.oncall.ongoing');
            $warrantyClaim->push();
            
            dispatch(new CompletingWarrantyClaimFormJob($warrantyClaim));
        }

        return redirect()->route('admin.warranty-claims.show', [$warrantyClaim]);
    }

    public function cosiderOncallStatus($warrantyClaim)
    {
        $warrantyClaim->warranty_claim_action->load('service_report_pdfs_for_daikin', 'service_report_pdfs_for_ywartaw', 'deliver_order_pdfs');

        $daikin_pdf = $warrantyClaim->warranty_claim_action->service_report_pdfs_for_daikin;
        $ywartaw_pdf = $warrantyClaim->warranty_claim_action->service_report_pdfs_for_ywartaw;
        $deliver_order_pdf = $warrantyClaim->warranty_claim_action->deliver_order_pdfs;

        if (! $daikin_pdf->isEmpty() && ! $ywartaw_pdf->isEmpty() && ! $deliver_order_pdf->isEmpty()) {
            $warrantyClaim->oncall->status = config('status.oncall.complete');    
            $warrantyClaim->push();
        }
    }
}
