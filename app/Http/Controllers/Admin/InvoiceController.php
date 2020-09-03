<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use App\PaymentStep;
use Illuminate\Http\Request;
use App\Traits\ImageUploadTrait;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreInvoiceRequest;

class InvoiceController extends Controller
{
    use ImageUploadTrait;
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'invoice_pdf' => 'required|mimes:pdf|max:' . config('panel.pdf_max_size'),
        ]);

        if ( $validator->fails()) {
            return redirect()->back()->with('payment_step_id', $request->payment_step_id)
            ->withErrors($validator)
            ->withInput();    
        }

        $iteration = (new PaymentStep)->get_current_iteration($request->payment_step_id);
        
        $title = "PaymentStep_" . $request->payment_step_id . "_Iteration_" . $iteration . "__";
        $invoice_pdf = static::storeFileToBucket($title, $request->invoice_pdf, config('payment.invoice_pdf_path'));

        $invoice = Invoice::create([
            'title' => $request->title,
            'description' => $request->description,
            'invoice_pdf' => $invoice_pdf,
            'iteration' => $iteration,
            'created_by_id' => auth()->user()->id,
            'payment_step_id' => $request->payment_step_id
        ]);

        return redirect()->back()->with('payment_step_id', $request->payment_step_id);

    }

}
