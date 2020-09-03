<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\CustomerEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCustomerEmailRequest;
use App\Http\Requests\StoreCustomerEmailRequest;
use App\Http\Requests\UpdateCustomerEmailRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerEmailController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerEmails = CustomerEmail::all();

        return view('admin.customerEmails.index', compact('customerEmails'));
    }

    public function create()
    {
        abort_if(Gate::denies('customer_email_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.customerEmails.create', compact('customers'));
    }

    public function store(StoreCustomerEmailRequest $request)
    {
        $customerEmail = CustomerEmail::create($request->all());

        return redirect()->route('admin.customer-emails.index');
    }

    public function edit(CustomerEmail $customerEmail)
    {
        abort_if(Gate::denies('customer_email_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customerEmail->load('customer');

        return view('admin.customerEmails.edit', compact('customers', 'customerEmail'));
    }

    public function update(UpdateCustomerEmailRequest $request, CustomerEmail $customerEmail)
    {
        $customerEmail->update($request->all());

        return redirect()->route('admin.customer-emails.index');
    }

    public function show(CustomerEmail $customerEmail)
    {
        abort_if(Gate::denies('customer_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerEmail->load('customer');

        return view('admin.customerEmails.show', compact('customerEmail'));
    }

    public function destroy(CustomerEmail $customerEmail)
    {
        abort_if(Gate::denies('customer_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerEmail->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerEmailRequest $request)
    {
        CustomerEmail::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
