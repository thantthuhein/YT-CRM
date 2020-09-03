<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\OnCall;
use App\Project;
use App\Customer;
use App\Enquiry;
use App\ServiceType;
use App\SaleContract;
use App\ServicingSetup;
use Illuminate\Http\Request;
use App\Services\OnCallsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOnCallRequest;
use App\Http\Requests\UpdateOnCallRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyOnCallRequest;
use App\Repair;
use App\WarrantyClaim;

class OnCallController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('on_call_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = $request->has('status') && $request->status != "" ? $request->status : 'pending';

        $onCalls = OnCall::where('status', $status)->latest()->paginate(10);

        $statuses = config('status.oncall');

        return view('admin.onCalls.index', compact('onCalls', 'statuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('on_call_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_types = ServiceType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sale_contracts = SaleContract::all()->pluck('morphable_type', 'id')->prepend(trans('global.pleaseSelect'), '');
        
        $customers = Customer::all();

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.onCalls.create', compact('projects', 'service_types', 'customers', 'created_bies', 'updated_bies', 'sale_contracts'));
    }

    public function store(StoreOnCallRequest $request)//StoreOnCallRequest
    {
        // dd(config('servicingSetup.request_type_oncall'));
        $user_id = auth()->user()->id;
        
        $data = $request->all();
        $sale_contract = SaleContract::find($request->sale_contract_id);

        /**
         * to check enquiry or quotation
         */
        if($sale_contract->morphableEnquiryQuotation->enquiries_id){
            $projectId = $sale_contract->morphableEnquiryQuotation->enquiry()->project_id;
        }
        else{
            $projectId = $sale_contract->morphableEnquiryQuotation->project_id;
        }

        if(isset($projectId)){
            $data['project_id'] = $projectId;
        }

        $data['created_by_id'] = $user_id;

        $onCall = OnCall::create($data);
        
        switch($request->service_type_id){
            case 1:
                Repair::create([
                    'oncall_id' => $onCall->id,
                    'team_type' => $sale_contract->installation_type,
                    'created_by_id' => $user_id
                ]);
                break;
            case 2:
                $maintenance = ServicingSetup::create([
                    'oncall_id' => $onCall->id,
                    'status' => NULL,
                    'request_type' => config('servicingSetup.request_type_oncall'),
                    'team_type' => $sale_contract->installation_type == 'Both' ? 'both' : $sale_contract->installation_type,
                    'created_by_id' => $user_id,
                    'project_id' => $sale_contract->customer->enquiries()->first()->project->id ?? NULL,
                    'estimated_date' => $request->tentative_date
                ]);
                $maintenance->attachMorph($onCall);
                break;
            case 3:
                WarrantyClaim::create([
                    'oncall_id' => $onCall->id,
                    'status' => 'submitted',
                    'created_by_id' => $user_id,
                ]);
                break;
        }

        return redirect()->route('admin.on-calls.index');
    }

    public function edit(OnCall $onCall)
    {
        abort_if(Gate::denies('on_call_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $service_types = ServiceType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $onCall->load('project', 'service_type', 'customer', 'created_by', 'updated_by');

        return view('admin.onCalls.edit', compact('projects', 'service_types', 'customers', 'created_bies', 'updated_bies', 'onCall'));
    }

    public function update(UpdateOnCallRequest $request, OnCall $onCall)
    {
        $onCall->update($request->all());

        return redirect()->route('admin.on-calls.index');
    }

    public function show(OnCall $onCall)
    {
        abort_if(Gate::denies('on_call_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onCall->load('project', 'service_type', 'customer', 'created_by', 'updated_by');
        
        return view('admin.onCalls.show', compact('onCall'));
    }

    public function destroy(OnCall $onCall)
    {
        abort_if(Gate::denies('on_call_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $onCall->delete();

        return back();
    }

    public function massDestroy(MassDestroyOnCallRequest $request)
    {
        OnCall::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function selectSaleContract()
    {
        $sale_contracts = SaleContract::all();

        return view('admin.onCalls.selectSaleContract', compact('sale_contracts'));
    }
}
