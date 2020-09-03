<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Company;
use App\Enquiry;
use App\Project;
use App\Customer;
use Carbon\Carbon;
use App\AirconType;
use App\TypeOfSale;
use App\CustomerPhone;
use App\EnquiriesType;
use App\AirconTypeConnector;
use Illuminate\Http\Request;
use App\Services\EnquiryService;
use App\Rules\NoEmptyStringArray;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\UpdateEnquiryRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyEnquiryRequest;

class EnquiriesController extends Controller
{
    public function __construct()
    {
        $this->service = new EnquiryService();
    }

    public function index(Request $request)
    {
        abort_if(Gate::denies('enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiries = $this->service->search($request);

        $typeOfSales = TypeOfSale::pluck('type', 'id')->prepend('Please Select', '');

        $airconTypes = AirconType::pluck('type', 'id');
        
        return view('admin.enquiries.index', compact('enquiries','typeOfSales', 'airconTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return $this->service->getCreateFormData();            
    }    

    public function store(StoreEnquiryRequest $request)
    {
        abort_if(Gate::denies('enquiry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $userId = Auth::user()->id;
        
        $this->service->validate($request);
    
        $news = $this->service->handleForNew($request);

        $enquiry = $this->service->make($request, $userId, $news['new_customer'], $news['new_company'], $news['new_project']);

        $enquiry->airconTypes()->attach($request->airconTypes);

        return redirect()->route('admin.enquiries.index');
    }

    public function edit(Enquiry $enquiry)
    {
        abort_if(Gate::denies('enquiry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $airconTypes = AirconType::select('id','type','parent')->orderBy('order', 'asc')->get();

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enquiries_types = EnquiriesType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $type_of_sales = TypeOfSale::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $airconTypeParent = AirconType::all()->pluck('parent', 'id');

        $childTree = $this->service->getAirconTypeTree();

        $customerPhones = optional($enquiry->customer)->customerPhones()->get(['id', "phone_number"])->toArray();

        $enquiry->load('user', 'enquiries_type', 'type_of_sales', 'customer', 'company', 'project', 'created_by', 'updated_by');

        $sale_engineers = get_sale_engineers();

        return view('admin.enquiries.edit', compact('users', 'enquiries_types', 'type_of_sales', 'customers', 'companies', 'projects', 'created_bies', 'updated_bies', 'enquiry', 'airconTypes', 'airconTypeParent', 'childTree', 'customerPhones', 'sale_engineers'));
    }

    public function update(UpdateEnquiryRequest $request, Enquiry $enquiry)
    {                
        if($request->type_of_sales_id != 1){
            $request->validate([
                'customer_email' => "required",
                'company' => "required"
            ]);
        }

        $enquiry = $this->service->update($request, $enquiry);

        return redirect()->route('admin.enquiries.show', $enquiry->id);
    }

    public function show(Enquiry $enquiry)
    {
        abort_if(Gate::denies('enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiry->load('user', 'enquiries_type', 'type_of_sales', 'customer', 'company', 'project', 'created_by', 'updated_by');

        return view('admin.enquiries.show', compact('enquiry'));
    }

    public function destroy(Enquiry $enquiry)
    {
        abort_if(Gate::denies('enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->service->delete();

        return back();
    }

    public function massDestroy(MassDestroyEnquiryRequest $request)
    {
        Enquiry::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
