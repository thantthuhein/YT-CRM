<?php

namespace App\Http\Controllers\Admin;

use App\Invoice;
use Carbon\Carbon;
use App\PaymentStep;
use App\SaleContract;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentStepController extends Controller
{
    public function completePaymentStep(Request $request)
    {
        $paymentStep = PaymentStep::findOrFail($request->payment_step_id);
        
        if ( $paymentStep->invoices->isEmpty() ) {
            return redirect()->back()->with('no_invoices_error', 'There is no Invoices');
        }

        $paymentStep->completed_at = Carbon::now();
        $paymentStep->completed_by_id = auth()->user()->id;
        $paymentStep->save();

        return redirect()->back()->with('payment_step_id', $request->payment_step_id);
    }

    public function unCompletePaymentStep(Request $request)
    {
        $paymentStep = PaymentStep::findOrFail($request->payment_step_id);
        $paymentStep->completed_by_id = NULL;
        $paymentStep->completed_at = NULL;
        $paymentStep->save();

        return redirect()->back()->with('payment_step_id', $request->payment_step_id);
    }

    public function editTitle(SaleContract $saleContract, PaymentStep $paymentStep)
    {
        return view('admin.saleContracts.editPaymentStepTitle', compact('paymentStep', 'saleContract'));
    }

    public function updateTitle(PaymentStep $paymentStep, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
        ]);

        $paymentStep->update($request->all());

        return redirect()->route('admin.sale-contracts.make-payment', $paymentStep->saleContract)->with('payment_step_id', $paymentStep->id);
    }
}
