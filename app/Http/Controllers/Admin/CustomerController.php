<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Company;
use App\Customer;
use App\CustomerNote;
use App\SaleContract;
use App\ServicingSetup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyCustomerRequest;

class CustomerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::latest()->paginate(10);

        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::all()->pluck('name', 'id');

        return view('admin.customers.create', compact('companies'));
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        
        $customer->notes()->save(new \App\CustomerNote(['notes' => $request->notes]));

        $customer->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.customers.index');
    }

    public function edit(Customer $customer)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companies = Company::all()->pluck('name', 'id');

        $customer->load('companies');

        return view('admin.customers.edit', compact('companies', 'customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        
        $customer->companies()->sync($request->input('companies', []));

        return redirect()->route('admin.customers.index');
    }

    public function show(Customer $customer)
    {
        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->load('companies');

        $saleContracts = SaleContract::with('morphableEnquiryQuotation')->get();

        $saleContracts = $saleContracts->filter(function($saleContract) use ($customer) {
            return $saleContract->customer->id == $customer->id;
        });

        return view('admin.customers.show', compact('customer', 'saleContracts'));
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        Customer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function createNote(Customer $customer) 
    {
        return view('admin.customers.createNote', compact('customer'));
    }

    public function storeNote(Customer $customer, Request $request)
    {
        $this->validate($request, [
            'notes' => 'required',
            'customer_id' => 'required',
        ]);

        $customerNote = CustomerNote::create($request->all());
        if( $customerNote->created_by_id ) {
            $customerNote->updated_by_id = auth()->user()->id;
        } else {
            $customerNote->created_by_id = auth()->user()->id;
        }
        $customerNote->save();

        return redirect()->route('admin.customers.show', $customer)->with('customer_name', $customer->name);
    }
}
