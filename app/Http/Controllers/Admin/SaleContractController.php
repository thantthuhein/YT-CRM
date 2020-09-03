<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Enquiry;
use App\Invoice;
use App\Quotation;
use Carbon\Carbon;
use App\SubCompany;
use App\HandOverPdf;
use App\PaymentStep;
use App\SaleContract;
use App\ServicingTeam;
use App\PaymentHistory;
use App\SaleContractPdf;
use App\HandOverChecklist;
use App\SubComInstallation;
use App\InHouseInstallation;
use Illuminate\Http\Request;
use App\InstallationProgress;
use App\MaterialDeliveryPdfs;
use App\InhouseInstallationTeam;
use App\Traits\ImageUploadTrait;
use App\MaterialDeliveryProgress;
use App\Rules\NoEmptyStringArray;
use App\EquipmentDeliverySchedule;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\SaleContractService;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\StoreSaleContractRequest;
use App\Http\Requests\StoreSubComTeamAssignRequest;
use App\Http\Requests\UpdateSaleContractRequest;
use App\Http\Requests\MassDestroySaleContractRequest;
use App\Http\Requests\StoreDataAFterCompletedRequest;
use App\Http\Requests\StoreMaterialDeliveryProgressRequest;
use App\Http\Requests\StoreEquipmentDeliveryScheduleRequest;
use App\Http\Requests\UploadOtherDocumentSaleContractRequest;
use App\Jobs\CompletingActualInstallationReportPdfUploadJob;
use App\Jobs\CompletingInstallationProgressWeeklyUpdateJob;
use App\Jobs\CompletingSaleContractUploadedBySaleEngineerJob;

class SaleContractController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        abort_if(Gate::denies('sale_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContracts = SaleContract::latest()->paginate(10);

        return view('admin.saleContracts.index', compact('saleContracts'));
    }

    public function choose(Request $request){
        $quotations = Quotation::when($request->has('customer_name'), function($q) use($request){
            $q->whereHas('customer', function($cust) use($request){
                $cust->where('name', "like", "%". $request->customer_name . "%");
            });
        })->doesntHave('saleContract')->get();

        $enquiries = Enquiry::when($request->has('customer_name'), function($q) use($request){
            $q->whereHas('customer', function($cust) use($request){
                $cust->where('name', "like", "%". $request->customer_name . "%");
            });
        })->doesntHave('saleContract')->get();

        return view('admin.saleContracts.choose', compact('enquiries', 'quotations'));
    }

    public function createFromEnquiry(Enquiry $enquiry)
    {
        abort_if(Gate::denies('sale_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $route = route("admin.enquiries.sale-contracts.store", [$enquiry]);

        $hasInstallation = $enquiry->has_installation;

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.saleContracts.create', compact('created_bies', 'updated_bies', 'hasInstallation', 'route'));
    }

    public function createFromQuotation(Quotation $quotation)
    {
        abort_if(Gate::denies('sale_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $route = route("admin.quotations.sale-contracts.store", [$quotation]);

        $hasInstallation = $quotation->enquiry()->has_installation;

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.saleContracts.create', compact('created_bies', 'updated_bies', 'hasInstallation', 'route'));
    }

    public function storeFromEnquiry(Enquiry $enquiry, StoreSaleContractRequest $request)
    {
        abort_if(Gate::denies('sale_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiry->status = 'active';
        $enquiry->save();

        return SaleContractService::storeSaleContract($enquiry, $request);
    }

    public function storeFromQuotation(Quotation $quotation, StoreSaleContractRequest $request)
    {
        abort_if(Gate::denies('sale_contract_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return SaleContractService::storeSaleContract($quotation, $request);
    }    

    public function createEquipmentDeliverySchedule(SaleContract $saleContract)
    {
        return view('admin.saleContracts.createEquipmentDeliverySchedule', compact('saleContract'));
    }

    public function storeEquipmentDeliverySchedule(SaleContract $saleContract, StoreEquipmentDeliveryScheduleRequest $request)
    {
        $datas = $request->all();
        $userId = auth()->user()->id;
        /**
         * Equipment Delivery Schedule
         */
        foreach ($datas['description'] as $key => $description) {
            if ($deliveredAt = $datas['delivered_at'][$key]) {
                EquipmentDeliverySchedule::create([
                    'sale_contract_id' => $saleContract->id,
                    'description' => $description,
                    'delivered_at' => $deliveredAt,
                    'created_by_id' => $userId
                ]);
            }
        }

        return redirect()->route('admin.sale-contracts.show', $saleContract->id);
    }

    public function createDocumentPdf(SaleContract $saleContract)
    {
        return view('admin.saleContracts.createDocumentPdf', compact('saleContract'));
    }


    public function storeDocumentPdf(SaleContract $saleContract, Request $request)
    {
        $this->validate($request, [
            'text' => [
                "required",
                "array"
            ],
            'text.*' => [
                "required",
                "string"
            ],
            'file' => [
                "required",
                "array"
            ],
            'file.*' => [
                "required",
                "mimes:pdf"
            ]
        ]);
        $datas = $request->all();

        $titles = $datas['text'];
        $pdfs = $datas['file'];      

        $userId = auth()->user()->id;

        foreach($titles as $key => $title){
            if(array_key_exists($key, $pdfs)){

                $pdf = $pdfs[$key];
                /**
                 * Save sale contract pdfs
                 */
                $folder = config('bucket.sale_contract');
                $url = $this->storeFileToBucket($title, $pdf, $folder);

                /**
                 * Store pdf in database
                 */
                // $iteration = 1;

                SaleContractPdf::create([
                    'title' => $title,
                    'url' => $url,
                    'sale_contract_id' => $saleContract->id,
                    'uploaded_by_id' => $userId
                ]);

            }
        }
        
        return redirect()->route('admin.sale-contracts.show', $saleContract->id);
    }

    public function uploadOtherDocuments(SaleContract $saleContract){

        abort_if(Gate::denies('upload_other_docs_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompanies = SubCompany::all()->pluck('company_name', 'id');

        $withInstallationTitles = config('pdfTypes.sale_contract.with_installation.other_docs');

        return view('admin.saleContracts.uploadOtherDocuments', compact('saleContract', 'subCompanies', 'withInstallationTitles'));
    }

    public function storeOtherDocuments(SaleContract $saleContract, UploadOtherDocumentSaleContractRequest $request){

        $userId = Auth::user()->id;
        $datas = $request->all();

        $iteration = $saleContract->nextIteration();
        $pdfs = $datas['pdfs'];

        $otherDocsConfig = config('pdfTypes.sale_contract.with_installation.other_docs');
        $folder = config("bucket.sale_contract") . config("bucket.other_documents") . "/I-". $iteration;

        foreach($pdfs as $key => $pdf){
            $title = $otherDocsConfig[$key];

            if(is_array($pdf)){
                foreach($pdf as $otherPdf){
                    $url = $this->storeFileToBucket($title, $otherPdf, $folder);
                    SaleContractPdf::create([
                        'iteration' => $iteration,
                        'title' => $title,
                        'url' => $url,
                        'sale_contract_id' => $saleContract->id,
                        'uploaded_by_id' => $userId,
                        'is_other_docs' => true
                    ]);
                }
            }
            else{
                $url = $this->storeFileToBucket($title, $pdf, $folder);
                SaleContractPdf::create([
                    'iteration' => $iteration,
                    'title' => $title,
                    'url' => $url,
                    'sale_contract_id' => $saleContract->id,
                    'uploaded_by_id' => $userId,
                    'is_other_docs' => true
                ]);  
            }              
        }

        if($iteration == 1)
        {
            dispatch(new CompletingSaleContractUploadedBySaleEngineerJob($saleContract));
        }

        return redirect()->route('admin.sale-contracts.show', [$saleContract]);
    }

    public function edit(SaleContract $saleContract)
    {
        abort_if(Gate::denies('sale_contract_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saleContract->load('created_by', 'updated_by');

        return view('admin.saleContracts.edit', compact('created_bies', 'updated_bies', 'saleContract'));
    }

    public function update(UpdateSaleContractRequest $request, SaleContract $saleContract)
    {
        $saleContract->update($request->all());

        return redirect()->route('admin.sale-contracts.index');
    }

    public function show(SaleContract $saleContract)
    {
        abort_if(Gate::denies('sale_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContract->load('created_by', 'updated_by');

        $servicing_teams = ServicingTeam::all()->pluck('leader_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $saleContractPdfs = SaleContractPdf::where('sale_contract_id', $saleContract->id)->get();
        
        $docsForServiceManager = $saleContractPdfs->where('is_other_docs', TRUE);

        $saleContractDocs = $saleContractPdfs->where('is_other_docs', FALSE);

        return view('admin.saleContracts.show', compact('saleContract', 'servicing_teams', 'docsForServiceManager', 'saleContractDocs'));
    }

    public function destroy(SaleContract $saleContract)
    {
        abort_if(Gate::denies('sale_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContract->delete();

        return back();
    }

    public function massDestroy(MassDestroySaleContractRequest $request)
    {
        SaleContract::whereIn('id', request('ids'))->delete();
        
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function makePayment(SaleContract $saleContract)
    {        
        $saleContract->load('paymentSteps.invoices');
        
        $paymentSteps = $saleContract->paymentSteps;

        if( count($paymentSteps) == 0 ) {
            $totalPaymentSteps = config("paymentSteps");
            
            for($i = 1; $i <= $saleContract->payment_terms;$i++) {
    
                $paymentStep = new PaymentStep();
                $paymentStep->title = $totalPaymentSteps[$i];
                $paymentStep->sale_contract_id = $saleContract->id;
                $paymentStep->save();
    
            }
        }

        return view('admin.saleContracts.makePayment', compact('paymentSteps', 'saleContract'));
    }

    public function assignSubcomTeamsForm(SaleContract $saleContract)
    {
        $installationTypes = config('installationTypes');

        $subCompanies = SubCompany::all()->pluck('company_name', 'id')->prepend("Select subcompany", "");

        return view("admin.saleContracts.assignSubcomTeams", compact('subCompanies', 'installationTypes', 'saleContract'));
    }

    public function assignSubcomTeams(SaleContract $saleContract, StoreSubComTeamAssignRequest $request)
    {        
        $works = json_decode($request->works);                        

        foreach($works as $work){
            $workArray = get_object_vars($work);

            $subComInstallation = SubComInstallation::create([
                // 'completed_month' => $workArray['month'] ?? null,
                // 'completed_year' => $workArray['year'] ?? null,
                // 'rating' => $workArray['rating'] > 5 ? 5 : $workArray['rating'],
                'installation_type' => $workArray['work'],
                'sale_contract_id' => $saleContract->id
            ]);


            $subComInstallation->subCompanies()->attach($workArray['subcom']);
        }  
        
        return redirect()->route('admin.sale-contracts.show', [$saleContract]);
    }

    public function viewTeams(SaleContract $saleContract)
    {
        $saleContract->load('inHouseInstallation', 'inHouseInstallation.inhouseInstallationTeams', 'subComInstallations');

        return view('admin.saleContracts.teams', compact('saleContract'));
    }

    public function updateMaterialDeliveryProgress(SaleContract $saleContract, InHouseInstallation $inHouseInstallation, StoreMaterialDeliveryProgressRequest $request){
        $userId = Auth::user()->id;

        $validatedData = $request->all();

        $delivered_at = Carbon::parse($validatedData['delivered_at'])->format('Y-m-d');

        $validatedData['created_by_id'] = $userId;
        $validatedData['inhouse_installation_id'] = $inHouseInstallation->id;
        $validatedData['delivered_at'] = $delivered_at;

        $materialProgress = MaterialDeliveryProgress::create($validatedData);

        $folder = config('bucket.material_delivery_pdf');

        foreach($validatedData['material_pdf'] as $pdf){
            $url = $this->storeFileToBucket(null, $pdf, $folder);

            MaterialDeliveryPdfs::create([
                'material_delivery_progress_id' => $materialProgress->id,
                'pdf' => $url
            ]);
        }

        return back();
    }

    public function updateInstallationProgress(SaleContract $saleContract, InHouseInstallation $inHouseInstallation, Request $request){
        $userId = Auth::user()->id;

        $validatedData = $request->validate([
            'installation_progress' => "required|min:1|max:100|integer",
            'installation_remark' => 'nullable|string'
        ]);

        InstallationProgress::create([
            'progress' => $validatedData['installation_progress'],
            'remark' => $validatedData['installation_remark'],
            'created_by_id' => $userId,
            'inhouse_installation_id' => $inHouseInstallation->id
        ]);

        if($validatedData['installation_progress'] == 100){
            /**
             * Set status to complete
             */
            $inHouseInstallation->status = config('status.installation_status.complete');
        }
        else{
            /**
             * Set status to complete
             */
            $inHouseInstallation->status = config('status.installation_status.ongoing');
        }
        $inHouseInstallation->update();

        dispatch(new CompletingInstallationProgressWeeklyUpdateJob($inHouseInstallation));


        return back();
    }

    public function addInstallationTeams(SaleContract $saleContract, InHouseInstallation $inHouseInstallation, Request $request)
    {
        $userId = Auth::user()->id;
        
        $validatedData = $request->validate([
            'servicing_team_id' => "required|integer"
        ]);

        InhouseInstallationTeam::create([
            'created_by_id' => $userId,
            'servicing_team_id' => $request->servicing_team_id,
            'inhouse_installation_id' => $inHouseInstallation->id
        ]);

        return back();
    }

    public function addCompletedData(SaleContract $saleContract, InHouseInstallation $inHouseInstallation)
    {
        $handoverPdfTypes = config('pdfTypes.sale_contract.handover_pdfs');
        
        $inHouseInstallation->load('handOverChecklists');

        $checklists = $inHouseInstallation->handOverChecklists->groupBy('type');

        return view('admin.inHouseInstallations.afterCompleted.create', compact('saleContract', 'handoverPdfTypes', 'checklists'));
    }

    public function storeCompletedData(SaleContract $saleContract, InHouseInstallation $inHouseInstallation, StoreDataAFterCompletedRequest $request)
    {
        $datas = $request->all();

        $inHouseInstallation->tc_time = $datas['tc_time'];
        $inHouseInstallation->hand_over_date = $datas['hand_over_date'];
        // $inHouseInstallation->actual_installation_report_pdf = $url;
        $inHouseInstallation->save();
        
        if($request->has('handover_pdfs')){
            $handoverPdfs = $datas['handover_pdfs'];

            (new HandOverPdfController)->storeHandoverFiles($handoverPdfs, $inHouseInstallation);
        }

        return redirect()->route('admin.in-house-installations.show', [$inHouseInstallation])->withSuccess('Upload Success!');
    }

    public function uploadActualInstallationReportPdf(InHouseInstallation $inHouseInstallation)
    {
        return view('admin.inHouseInstallations.afterCompleted.actualInstallationReportPdf', compact('inHouseInstallation'));
    }

    public function storeActualInstallationReportPdf(InHouseInstallation $inHouseInstallation, Request $request)
    {
        $datas = $request->validate([
            'actual_installation_report_pdf'=> [
                'required',
                'mimes:pdf'
            ]
        ]);
        /**
         * Store file to bucket
         */
        $title = 'Actual Installation Report PDF';
        $folder = config("bucket.sale_contract") . config("bucket.in_house_installation");
        $file = $datas['actual_installation_report_pdf'];

        $url = $this->storeFileToBucket($title, $file, $folder);

        $inHouseInstallation->actual_installation_report_pdf = $url;
        $inHouseInstallation->save();

        dispatch(new CompletingActualInstallationReportPdfUploadJob($inHouseInstallation));

        return redirect()->route('admin.in-house-installations.show', [$inHouseInstallation])->withSuccess('Upload Success!');
    }
    
    public function approveProject(SaleContract $saleContract, InHouseInstallation $inHouseInstallation){
        abort_if(Gate::denies('sale_contract_approve_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = Auth::user();
        $currentDate = Carbon::now()->format('Y-m-d');
        $roles = $user->roles->pluck('id')->all();

        if(!in_array(4, $roles) && !in_array(6, $roles)) {
            abort(403);
        }

        /**
         * we have to change this 1 , 2 to 
         * the corrsponding role id of Service Manager and Project Manager
         * 
         * Above issue is done
         * Project manager id => 4
         * Service manager id => 6
         */
        if ( in_array( 6, $roles) ) {
            /**
             * Service Manger
             */
            $inHouseInstallation->approved_service_manager_id = $user->id;
            $inHouseInstallation->service_manager_approve_date = $currentDate;
        }
        if ( in_array( 4, $roles) ) {
            /**
             * Project Manager
             */
            $inHouseInstallation->approved_project_manager_id = $user->id;
            $inHouseInstallation->project_manager_approve_date = $currentDate;
        }        
        
        $inHouseInstallation->save();

        $inHouseInstallation->checkAndUpdateStatus();

        return redirect()->back()->withSuccess('Approved success!');
    }

    public function allUploadedFiles(SaleContract $saleContract)
    {        
        $saleContractPdfs = $saleContract->saleContractPdfs()->paginate(10);
        
        if ($saleContract->inHouseInstallation == NULL) {
            $handOverPdfs = [];
        } else {
            $handOverPdfs = $saleContract->inHouseInstallation->handOverPdfs()->paginate(10);
        }
        
        return view('admin.saleContracts.allUploadedPdfs', compact('saleContract', 'saleContractPdfs', 'handOverPdfs'));
    }

    public function editPaymentTerms(SaleContract $saleContract)
    {
        return view('admin.saleContracts.editPaymentTerms', compact('saleContract'));
    }

    public function updatePaymentTerms(SaleContract $saleContract, Request $request)
    {        
        //need to rafactor later
        $saleContract->load('paymentSteps.invoices');

        $steps = $saleContract->paymentSteps->filter(function($paymentStep) {
            return ! $paymentStep->invoices->isEmpty();
        });

        if (! $steps->isEmpty()) {
            return abort(403);
        }

        $rules = ['payment_terms' => 'integer|min:1|max:8'];

        $this->validate($request, $rules);

        $saleContract->update($request->all());

        $paymentSteps = $saleContract->payment_terms;

        $saleContract->paymentSteps()->delete();

        $totalPaymentSteps = config("paymentSteps");
        
        for ($i = 1; $i <= $saleContract->payment_terms;$i++) {    
            $paymentStep = new PaymentStep();
            $paymentStep->title = $totalPaymentSteps[$i];
            $paymentStep->sale_contract_id = $saleContract->id;
            $paymentStep->save();                
        }

        return redirect()->route('admin.sale-contracts.show', $saleContract->id);
    }
}