<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPaymentHistoryRequest;
use App\Http\Requests\StorePaymentHistoryRequest;
use App\Http\Requests\UpdatePaymentHistoryRequest;
use App\PaymentHistory;
use App\SaleContract;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaymentHistoryController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('payment_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentHistories = PaymentHistory::all();

        return view('admin.paymentHistories.index', compact('paymentHistories'));
    }

    public function create()
    {
        abort_if(Gate::denies('payment_history_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.paymentHistories.create', compact('sale_contracts', 'created_bies', 'updated_bies'));
    }

    public function store(StorePaymentHistoryRequest $request)
    {
        $paymentHistory = PaymentHistory::create($request->all());

        return redirect()->route('admin.payment-histories.index');
    }

    public function edit(PaymentHistory $paymentHistory)
    {
        abort_if(Gate::denies('payment_history_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $paymentHistory->load('sale_contract', 'created_by', 'updated_by');

        return view('admin.paymentHistories.edit', compact('sale_contracts', 'created_bies', 'updated_bies', 'paymentHistory'));
    }

    public function update(UpdatePaymentHistoryRequest $request, PaymentHistory $paymentHistory)
    {
        $paymentHistory->update($request->all());

        return redirect()->route('admin.payment-histories.index');
    }

    public function show(PaymentHistory $paymentHistory)
    {
        abort_if(Gate::denies('payment_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentHistory->load('sale_contract', 'created_by', 'updated_by');

        return view('admin.paymentHistories.show', compact('paymentHistory'));
    }

    public function destroy(PaymentHistory $paymentHistory)
    {
        abort_if(Gate::denies('payment_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $paymentHistory->delete();

        return back();
    }

    public function massDestroy(MassDestroyPaymentHistoryRequest $request)
    {
        PaymentHistory::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
