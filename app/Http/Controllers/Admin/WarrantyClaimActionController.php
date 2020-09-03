<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\ServiceReportPdfDaikin;
use App\DeliverOrderPdf;
use App\RepairTeam;
use App\ServiceReportPdfYwarTaw;
use App\ServicingTeam;
use App\WarrantyClaim;
use App\WarrantyClaimAction;
use Illuminate\Http\Request;
use App\WarrantyClaimRemark;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\CompletingWarrantyEstimatedDateJob;
use App\Jobs\CompletingWarrantyActionPdfsUploadJob;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreWarrantyClaimActionRequest;
use App\Http\Requests\UpdateWarrantyClaimActionRequest;
use App\Http\Requests\MassDestroyWarrantyClaimActionRequest;

class WarrantyClaimActionController extends Controller
{
    use MediaUploadingTrait, ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('warranty_claim_action_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimActions = WarrantyClaimAction::all();

        return view('admin.warrantyClaimActions.index', compact('warrantyClaimActions'));
    }

    public function create(WarrantyClaim $warrantyClaim)
    {
        abort_if(Gate::denies('warranty_claim_action_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $repair_teams = RepairTeam::all()->pluck('leader_name', 'id')->prepend('Please Select', '');

        return view('admin.warrantyClaimActions.create', compact('repair_teams', 'warrantyClaim'));
    }

    public function store(StoreWarrantyClaimActionRequest $request, WarrantyClaim $warrantyClaim)
    {
        $userId = auth()->user()->id;
        $data = $request->validated();
        $data['created_by_id'] = $userId;

        $warrantyClaimAction = WarrantyClaimAction::create($data);

        // $warrantyClaimAction->servicingTeams()->attach($request->servicing_team_id);
        $warrantyClaimAction->repair_team_id = $request->repair_team_id;

        $warrantyClaim->warranty_claim_action_id = $warrantyClaimAction->id;
        $warrantyClaim->update();        

        return redirect()->route('admin.warranty-claims.show', [$warrantyClaim]);
    }

    public function edit(WarrantyClaimAction $warrantyClaimAction)
    {
        abort_if(Gate::denies('warranty_claim_action_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $warrantyClaimAction->load('created_by', 'updated_by');

        return view('admin.warrantyClaimActions.edit', compact('created_bies', 'updated_bies', 'warrantyClaimAction'));
    }

    public function update(UpdateWarrantyClaimActionRequest $request, WarrantyClaimAction $warrantyClaimAction)
    {
        $userId = Auth::user()->id;

        $warrantyClaimAction->daikin_rep_name = $request->daikin_rep_name;
        $warrantyClaimAction->daikin_rep_phone_number = $request->daikin_rep_phone_number;
        $warrantyClaimAction->estimate_date = $request->estimate_date;
        
        if($request->has('repair_team_id'))
        {
            $warrantyClaimAction->warrantyClaim->warranty_claim_action()->update([
                'actual_date' => $request->actual_date,
                'updated_by_id' => $userId
            ]);

            $warrantyClaimAction->repair_team_id = $request->repair_team_id;
            $warrantyClaimAction->save();
        }

        $warrantyClaimAction->actual_date = $request->actual_date;
        $warrantyClaimAction->updated_by_id = $userId;

        /**
         * check and add remark
         */
        if($request->has('remark') && $request->remark != null)
        {
            WarrantyClaimRemark::create([
                'remark' => $request->remark,
                'warranty_claim_action_id' => $warrantyClaimAction->id,
                'created_by_id' => $userId
            ]);
        }

        /**
         * upload pdf
         */
        $folder = config('bucket.warranty_claim') ."/". config('bucket.warranty_claim_action');

        if($request->hasFile('service_report_pdf_ywar_taw')){
            $title = $warrantyClaimAction->id. "_service_report_pdf_ywar_taw";
            foreach($request->service_report_pdf_ywar_taw as $pdfFile) {
                $url = $this->storeFileToBucket($title, $pdfFile, $folder);
                ServiceReportPdfYwarTaw::create([
                    'url' => $url,
                    'warranty_claim_action_id' => $warrantyClaimAction->id,
                ]);
            }
        }

        if($request->hasFile('service_report_pdf_daikin')){
            $title = $warrantyClaimAction->id. "_service_report_pdf_daikin";
            foreach($request->service_report_pdf_daikin as $pdfFile) {
                $url = $this->storeFileToBucket($title, $pdfFile, $folder);
                ServiceReportPdfDaikin::create([
                    'url' => $url,
                    'warranty_claim_action_id' => $warrantyClaimAction->id,
                ]);
            }
        }

        if($request->hasFile('deliver_order_pdf')){
            $title = $warrantyClaimAction->id. "_deliver_order_pdf";
            foreach($request->deliver_order_pdf as $pdfFile) {
                $url = $this->storeFileToBucket($title, $pdfFile, $folder);
                DeliverOrderPdf::create([
                    'url' => $url,
                    'warranty_claim_action_id' => $warrantyClaimAction->id,
                ]);
            }
        }

        $warrantyClaimAction->update();

        if ($warrantyClaimAction->service_report_pdf_ywar_taw != null
            && $warrantyClaimAction->service_report_pdf_daikin != null
            && $warrantyClaimAction->deliver_order_pdf != null)
            {
                dispatch(new CompletingWarrantyActionPdfsUploadJob($warrantyClaimAction->warrantyClaim));
            } 

        dispatch(new CompletingWarrantyEstimatedDateJob($warrantyClaimAction->warrantyClaim));

        return redirect()->route('admin.warranty-claims.show', [$warrantyClaimAction->warrantyClaim]);
    }

    public function show(WarrantyClaimAction $warrantyClaimAction)
    {
        abort_if(Gate::denies('warranty_claim_action_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimAction->load('created_by', 'updated_by');

        return view('admin.warrantyClaimActions.show', compact('warrantyClaimAction'));
    }

    public function destroy(WarrantyClaimAction $warrantyClaimAction)
    {
        abort_if(Gate::denies('warranty_claim_action_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $warrantyClaimAction->delete();

        return back();
    }

    public function massDestroy(MassDestroyWarrantyClaimActionRequest $request)
    {
        WarrantyClaimAction::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createPdfs(WarrantyClaimAction $warrantyClaimAction){
        // dd($warrantyClaimAction);
        return view('admin.warrantyClaimActions.edit', compact('warrantyClaimAction'));
    }
}
