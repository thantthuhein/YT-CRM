<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\User;
use App\Enquiry;
use App\Customer;
use App\Quotation;
use App\QuotationRevision;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Services\QuotationService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreQuotationRequest;
use App\Http\Requests\UpdateQuotationRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\MassDestroyQuotationRequest;

class QuotationController extends Controller
{
    use ImageUploadTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('quotation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $status = $request->has('selected_status') ? $request->selected_status : "possible";        
                
        if ($request->has('quotation_number') && !empty($request->quotation_number)) {

            $quotations = Quotation::whereRaw('match(number, quotation_number, quotation_number_type, year) against (?)',$request->quotation_number)
            ->when($status != 'all', function($q) use ($status) {
                $q->where('status', '=', $status);
            })
            ->when($request->has('sales_engineer') && $request->sales_engineer != '', function($query) use ($request) {
                $query->whereHas('enquiries', function($query) use ($request) {
                    $query->whereHas('user', function($query) use ($request) {
                        $query->where('id', $request->sales_engineer);
                    });
                });
            })
            ->paginate(10);

        } else {
            $quotations = Quotation::when($status != 'all', function($q) use ($status) {
                $q->where('status', '=', $status);
            })
            ->when($request->has('sales_engineer') && $request->sales_engineer != '', function($query) use ($request) {
                $query->whereHas('enquiries', function($query) use ($request) {
                    $query->whereHas('user', function($query) use ($request) {
                        $query->where('id', $request->sales_engineer);
                    });
                });
            })          
            ->latest()->paginate(10);
        }

        $salesEngineers = User::whereHas('roles', function($query) {
            return $query->where('title', 'Sales Engineer');
        })
        ->pluck('name', 'id')
        ->prepend(trans('global.pleaseSelect'), '');
        
        return view('admin.quotations.index', compact('quotations', 'salesEngineers'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('quotation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $enquiry = Enquiry::findOrFail($request->query('enquiry_id'));
        
        $customer = Customer::findOrFail($enquiry->created_by_id);
        
        return view('admin.quotations.create', compact('enquiry'));
    }
    
    public function store(StoreQuotationRequest $request) //StoreQuotationRequest
    {
        (new QuotationService)->createQuotation($request->all());
        
        return redirect()->route('admin.quotations.index');
    }

    public function edit(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $enquiries = Enquiry::all()->pluck('location', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $quotation->load('customer', 'enquiries', 'created_by', 'updated_by');

        return view('admin.quotations.edit', compact('customers', 'enquiries', 'created_bies', 'updated_bies', 'quotation'));
    }

    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {        
        $quotation->update([
            'quotation_number_type' => $request->quotation_number_type,
            'number' => $request->number,
            'year' => $request->year,
            'customer_address' => $request->customer_address,
            'status' => $request->status,
            'quotation_number' => $request->number,
            ]);
            
        if ( $request->has('quotation_pdf') ) {
            $title = 'Quotations_id_' . $quotation->id . '_edited_';
            $file_path = 'quotations';
            $quotation_pdf = static::storeFileToBucket($title, $request->quotation_pdf, $file_path);

            $quotationRevision = $quotation->quotationRevisions->first();
    
            $quotationRevision->update([
                'quotation_pdf' => $quotation_pdf,
            ]);
        }


        return redirect()->route('admin.quotations.show', $quotation->id);
    }

    public function show(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation->load('customer', 'enquiries', 'quotationRevisions', 'created_by', 'updated_by');
        
        $iteration_number = QuotationRevision::where('quotation_id', $quotation->id)->first();
        
        return view('admin.quotations.show', compact('quotation', 'iteration_number'));
    }
    
    public function destroy(Quotation $quotation)
    {
        abort_if(Gate::denies('quotation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation->delete();

        return back();
    }

    public function massDestroy(MassDestroyQuotationRequest $request)
    {
        Quotation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
