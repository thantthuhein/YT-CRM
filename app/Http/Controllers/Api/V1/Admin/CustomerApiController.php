<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\Admin\CustomerResource;
use Symfony\Component\HttpFoundation\Response;

class CustomerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerResource(Customer::with(['companies'])->get());
    }

    public function store(StoreCustomerRequest $request)
    {
        $customer = Customer::create($request->all());
        $customer->companies()->sync($request->input('companies', []));

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Customer $customer)
    {
        // abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        return new CustomerResource($customer->load(['companies', 'customerPhones']));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
        $customer->companies()->sync($request->input('companies', []));

        return (new CustomerResource($customer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    
    public function searchCustomer(Request $request){
        $customer = Customer::search($request->name ?? "")->with('customerPhones')->paginate(0);
        
        return $customer;
    }

    public function saleContracts(Customer $customer){
        $enquiries = $customer->enquiries()
        ->with('saleContract', 'customer', 'customer.customerPhones', 'company', 'project')
        ->whereHas('saleContract')
        ->doesntHave('quotations')
        ->get();

        $quotations = $customer->quotations()
        ->with('saleContract', 'customer', 'customer.customerPhones', 'enquiries.company' ,'enquiries.project')
        ->whereHas('saleContract')
        ->get();

        return response()->json([
            'enquiries' => $enquiries, 
            'quotations' => $quotations
        ]);
    }
}
