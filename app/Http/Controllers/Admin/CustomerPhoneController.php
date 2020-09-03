<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\CustomerPhone;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerPhoneRequest;
use App\Http\Requests\StoreCustomerPhoneRequest;
use App\Http\Requests\UpdateCustomerPhoneRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerPhoneController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_phone_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerPhones = CustomerPhone::all();

        return view('admin.customerPhones.index', compact('customerPhones'));
    }

    public function create()
    {
        abort_if(Gate::denies('customer_phone_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.customerPhones.create', compact('customers'));
    }

    public function store(StoreCustomerPhoneRequest $request)
    {
        $customerPhone = CustomerPhone::create($request->all());

        return redirect()->route('admin.customer-phones.index');
    }

    public function edit(CustomerPhone $customerPhone)
    {
        abort_if(Gate::denies('customer_phone_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customerPhone->load('customer');

        return view('admin.customerPhones.edit', compact('customers', 'customerPhone'));
    }

    public function update(UpdateCustomerPhoneRequest $request, CustomerPhone $customerPhone)
    {
        $customerPhone->update($request->all());

        return redirect()->route('admin.customer-phones.index');
    }

    public function show(CustomerPhone $customerPhone)
    {
        abort_if(Gate::denies('customer_phone_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerPhone->load('customer');

        return view('admin.customerPhones.show', compact('customerPhone'));
    }

    public function destroy(CustomerPhone $customerPhone)
    {
        abort_if(Gate::denies('customer_phone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerPhone->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerPhoneRequest $request)
    {
        CustomerPhone::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
