<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CustomerEmail;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerEmailRequest;
use App\Http\Requests\UpdateCustomerEmailRequest;
use App\Http\Resources\Admin\CustomerEmailResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerEmailApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_email_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerEmailResource(CustomerEmail::with(['customer'])->get());
    }

    public function store(StoreCustomerEmailRequest $request)
    {
        $customerEmail = CustomerEmail::create($request->all());

        return (new CustomerEmailResource($customerEmail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerEmail $customerEmail)
    {
        abort_if(Gate::denies('customer_email_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerEmailResource($customerEmail->load(['customer']));
    }

    public function update(UpdateCustomerEmailRequest $request, CustomerEmail $customerEmail)
    {
        $customerEmail->update($request->all());

        return (new CustomerEmailResource($customerEmail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerEmail $customerEmail)
    {
        abort_if(Gate::denies('customer_email_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerEmail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
