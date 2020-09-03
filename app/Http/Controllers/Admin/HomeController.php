<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use App\EnquiriesType;
use App\Enquiry;
use App\Quotation;
use App\TypeOfSale;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnquiryRequest;
use App\Http\Requests\UpdateEnquiryRequest;
use App\Http\Resources\Admin\EnquiryResource;
use App\InHouseInstallation;
use App\SaleContract;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HomeController
{
    public function index()
    {
        // abort_if(Gate::denies('enquiry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiries =  new EnquiryResource(Enquiry::with(['user', 'enquiries_type', 'type_of_sales', 'customer', 'company', 'project', 'created_by', 'updated_by'])->get());

        $phoneCallType = EnquiriesType::where('type', 'Phone Call')->first();
        $emailType = EnquiriesType::where('type', 'Email')->first();
        $walkInType = EnquiriesType::where('type', 'Walk-in')->first();

        $phoneCall = $enquiries->where('enquiries_type_id', $phoneCallType->id);
        $email = $enquiries->where('enquiries_type_id', $emailType->id);
        $walkIn = $enquiries->where('enquiries_type_id', $walkInType->id);

        $types = [
            'phoneCall' => count($phoneCall), 
            'email' => count($email), 
            'walkIn' => count($walkIn),
        ];
        $enquiriesType = collect($types);

        $pendingQuotations = Quotation::where('status', 'pending')->latest()->take(4)->get();

        $remainingJobs = auth()->user()->remainingJobs()->with("reminderType")->latest()->take(5)->get();

        $todayJobs = auth()->user()->remainingJobs()->whereDate('remaining_jobs.created_at', today())->latest()->take(5)->get();

        $currentProjects = SaleContract::whereHas('inHouseInstallation', function($query){
                $query->where('status', 'Ongoing');
            })
            ->with('inHouseInstallation.installationProgresses', 
                    'inHouseInstallation.inhouseInstallationTeams',
                    'inHouseInstallation.materialDeliveryProgresses')
            ->latest()
            ->take(2)
            ->get();

        $quotations = Quotation::cursor();
        $installations = InHouseInstallation::cursor();
        $customers = Customer::cursor();

        return view('home', compact('enquiries', 'quotations','installations', 'customers', 'enquiriesType', 'pendingQuotations', 'remainingJobs', 'todayJobs', 'currentProjects'));
        // $remainingJobs = auth()->user()->roles->flatten()->pluck('reminderTypes.*.remainingJobs')->flatten();
    }

    public function search(Request $request)
    {   
        $enquiries = Enquiry::search($request->q ?? "")->orderBy('id', 'desc')->paginate(10);

        $typeOfSales=TypeOfSale::pluck('type', 'id')->prepend('Please Select', '');
        
        return view('admin.enquiries.index', compact('enquiries','typeOfSales'));
    }
}
