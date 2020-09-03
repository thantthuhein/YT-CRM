<?php

namespace App\Services;

use App\User;
use App\Enquiry;
use App\Project;
use App\Company;
use App\Customer;
use App\AirconType;
use App\TypeOfSale;
use App\EnquiriesType;
use App\CustomerPhone;
use App\Rules\NoEmptyStringArrayForPhone;

class EnquiryService {

    public function search($request)
    {
        $paginateCount = $request->take ?? '5';                

        if ($request->has('q') && !empty($request->q)) {
            
            $request->aircon_type = '';

            $enquiries = Enquiry::search($request->q)
            ->when(!empty($request->status), function($status) use ($request) {
                $status->where('status', $request->status);
            })
            ->when(!empty($request->type), function($status) use ($request) {
                $status->where('type_of_sales_id', $request->type);
            })
            ->orderBy('id','desc')
            ->paginate($paginateCount);                    

        } else {
            $enquiries = Enquiry::when(!empty($request->status), function($status) use ($request) {
                $status->where('status', $request->status);
            })
            ->when(!empty($request->type), function($status) use ($request) {
                $status->where('type_of_sales_id', $request->type);
            })
            ->when(!empty($request->aircon_type), function($status) use ($request) {
                $status->whereHas('airconTypes', function($query) use ($request) {
                    $query->where('aircon_type_id', '=', $request->aircon_type);
                });
            })
            ->latest()
            ->paginate($paginateCount);
        }

        return $enquiries;
    }

    public function validate($request)
    {
        $data = [];

        if ($request->type_of_sales_id != 1) {
            if ($request->isOldCompany == null && $request->company_id == null)
            {
                $data['company'] = 'required';
            }
            if ($request->isOld == null && $request->customer_id == null){
                $data['customer_email'] = "required";
            }
        }
        if ($request->isOld == null && $request->customer_id == null) {
            $data['customer_id'] = [
                'integer',
                'nullable'
            ];
    
            $data['phones'] = [
                'required',
                'string',
                new NoEmptyStringArrayForPhone,
            ];            
        }

        $request->validate($data);
    }

    public function handleForNew($request)
    {
        if ($request->project_name) {
            $new_project = Project::create(['name'=>$request->project_name]);
        }

        if ($request->isOldCompany == null && $request->company_id == null) {
            if ($request->company) {
                $new_company = Company::create(['name'=>$request->company]);
            }
        }
        
        if ($request->isOld == null && $request->customer_id == null) {
            $new_customer = Customer::create(['name'=>$request->customer_name,'email'=>$request->customer_email]);
        }
        else {
            $new_customer = Customer::find($request->customer_id);
        }

        if ($request->isOldCompany == null && $request->company_id == null) {
            if ( isset($new_company) ) {
                $new_customer->companies()->attach($new_company->id);
            }
        }
        else {
            $new_customer->companies()->attach($request->company_id);
        }
        
        if ($request->phones && $request->phones != "") {
            $phones = json_decode($request->phones);
            foreach ($phones as $phone) {
                CustomerPhone::create([
                    'phone_number'=>$phone->phone,
                    'customer_id'=> $new_customer->id
                    ]);
            }
        }

        return [
            'new_customer' => $new_customer ?? NULL, 
            'new_company' => $new_company ?? NULL,
            'new_project' => $new_project ?? NULL,
        ];
    }

    public function make($request, $userId, $new_customer, $new_company, $new_project)
    {
        $enquiry = new Enquiry();

        $enquiry->location = $request->location;
        $enquiry->has_installation=$request->has_installation;
        $enquiry->has_future_action=$request->has_future_action;
        $enquiry->status=$request->status;
        $enquiry->receiver_name=$request->receiver_name;
        $enquiry->enquiries_type_id=$request->enquiries_type_id;
        $enquiry->type_of_sales_id=$request->type_of_sales_id;

        $enquiry->customer_id = $new_customer->id;

        if ($request->isOldCompany == null && $request->company_id == null) {
            $enquiry->company_id = $new_company->id ?? null;
        }
        else{
            $enquiry->company_id=$request->company_id;
        }

        $enquiry->project_id = $new_project->id ?? null;
        if ($request->has('sale_engineer_id')) {
            $enquiry->sale_engineer_id = $request->sale_engineer_id;
        }
        $enquiry->created_by_id = $userId;
        $enquiry->save();

        return $enquiry;
    }

    public function getCreateFormData()
    {
        $airconTypes = AirconType::select('id','type','parent')->orderBy('order', 'asc')->get();

        // get enquiryInCharge roles actually, will change func name later
        $sale_engineers = get_sale_engineers();

        $enquiries_types = EnquiriesType::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $type_of_sales = TypeOfSale::all()->pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companies = Company::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $projects = Project::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $airconTypeParent = AirconType::all()->pluck('parent', 'type');

        $childTree = $this->getAirconTypeTree();

        return view('admin.enquiries.create', compact('sale_engineers', 'enquiries_types', 'type_of_sales', 'customers', 'companies', 'projects', 'created_bies', 'updated_bies','airconTypes', 'childTree', 'airconTypeParent'));
    }

    public function update($request, $enquiry)
    {
        $userId = \Auth::id();

        $phones = json_decode($request->phones);
        
        $enquiry->update($request->except(['customer_id', 'company_id',]));

        $enquiry->updated_by_id = $userId;

        /**
         * Update Customer Name
         */
        $enquiry->customer()->update([
            'name' => $request->customer_name,
            'email' => $request->customer_email
        ]);

        /**
         * Update or create Company
         */
        if ($request->company) {
            $company = $enquiry->company()->updateOrCreate([
                'name' => $request->company
            ]);

            $enquiry->customer->companies()->attach($company->id);

            $enquiry->company_id = $company->id;
        } else {
            $enquiry->company_id = null;
        }

        //update or create project
        if ($request->project_name) {
            $project = $enquiry->project()->updateOrCreate([
                'name' => $request->project_name
            ]);

            $enquiry->project_id = $project->id;
        }
        else {
            $enquiry->project_id = null;
        }

        $enquiry->save();

        /**
         * Update customer phones
         */
        $enquiry->customer->customerPhones()->forceDelete();
        foreach($phones as $phone){
            $enquiry->customer->customerPhones()->create([
                'phone_number' => $phone->phone
            ]);
        }

        /**
         * Update Aircon Types
         */
        $enquiry->airconTypes()->sync($request->airconTypes);

        return $enquiry;
    }

    function getAirconTypeTree() {
        $airconTypes = AirconType::all();

        $typeTree = [];

        foreach ($airconTypes as $airconType) {
            $childs = AirconType::where('parent', $airconType->id)->pluck('id');
            $typeTree[$airconType->id] = $childs;
        }

        return $typeTree;
    }

    public function delete()
    {
        $enquiries = Enquiry::where('customer_id', $enquiry->customer->id)->get();

        $enquiry->project()->delete();
        $enquiry->airconTypes()->detach();
        $enquiry->delete();
    }
}