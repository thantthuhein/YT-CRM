<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\EnquiriesType;
use App\Enquiry;
use App\TypeOfSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\UpdateEnquiryRequest;
use App\Http\Resources\Admin\EnquiryResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnquiriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiries =  new EnquiryResource(Enquiry::with(['user', 'enquiries_type', 'type_of_sales', 'customer', 'company', 'project', 'created_by', 'updated_by'])->get());

        $phoneCallType = EnquiriesType::where('type', 'Phone Call')->first();
        $emailType = EnquiriesType::where('type', 'Email')->first();
        $walkInType = EnquiriesType::where('type', 'Walk-in')->first();

        $phoneCall = $enquiries->where('enquiries_type_id', $phoneCallType->id);
        $email = $enquiries->where('enquiries_type_id', $emailType->id);
        $walkIn = $enquiries->where('enquiries_type_id', $walkInType->id);

        return $enquiriesType = [
            'phoneCall' => count($phoneCall), 
            'email' => count($email), 
            'walkIn' => count($walkIn),
        ];
    }


    public function store(StoreEnquiryRequest $request)
    {
        $enquiry = Enquiry::create($request->all());

        return (new EnquiryResource($enquiry))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Enquiry $enquiry)
    {
        abort_if(Gate::denies('enquiry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EnquiryResource($enquiry->load(['user', 'enquiries_type', 'type_of_sales', 'customer', 'company', 'project', 'created_by', 'updated_by']));
    }

    public function update(UpdateEnquiryRequest $request, Enquiry $enquiry)
    {
        $enquiry->update($request->all());

        return (new EnquiryResource($enquiry))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Enquiry $enquiry)
    {
        abort_if(Gate::denies('enquiry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiry->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function searchEnquiries()
    {
        return Enquiry::all();
    }

}
