<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\CustomerPhone;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerPhoneRequest;
use App\Http\Requests\UpdateCustomerPhoneRequest;
use App\Http\Resources\Admin\CustomerPhoneResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerPhoneApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('customer_phone_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerPhoneResource(CustomerPhone::with(['customer'])->get());
    }

    public function store(StoreCustomerPhoneRequest $request)
    {
        $customerPhone = CustomerPhone::create($request->all());

        return (new CustomerPhoneResource($customerPhone))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CustomerPhone $customerPhone)
    {
        abort_if(Gate::denies('customer_phone_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CustomerPhoneResource($customerPhone->load(['customer']));
    }

    public function update(UpdateCustomerPhoneRequest $request, CustomerPhone $customerPhone)
    {
        $customerPhone->update($request->all());

        return (new CustomerPhoneResource($customerPhone))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CustomerPhone $customerPhone)
    {
        abort_if(Gate::denies('customer_phone_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customerPhone->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
    public function getCustomerPhone(Request $request){
        $customerPhones=CustomerPhone::where('customer_id',$request->id)->pluck('phone_number');
        return $customerPhones;
    }
}
