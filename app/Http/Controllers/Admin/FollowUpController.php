<?php

namespace App\Http\Controllers\Admin;

use App\FollowUp;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFollowUpRequest;
use App\Http\Requests\StoreFollowUpRequest;
use App\Http\Requests\UpdateFollowUpRequest;
use App\Jobs\CompletingFollowUpJob;
use App\QuotationRevision;
use App\Quotation;
use App\RemainingJob;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FollowUpController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('follow_up_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followUps = FollowUp::all();

        return view('admin.followUps.index', compact('followUps'));
    }

    public function create(Request $request, $quotation_id)
    {
        // dd($request->query('quotation_revision_id'));
        abort_if(Gate::denies('follow_up_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $quotation_revisions = QuotationRevision::with('quotation')->where('quotation_id', $quotation_id)->get();

        $quotation_revision = QuotationRevision::with('quotation')->findOrFail($request->query('quotation_revision_id'));
    
        $quotation = Quotation::findOrFail($quotation_id);

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.followUps.create', compact('quotation', 'quotation_revision', 'users'));
    }

    public function store(StoreFollowUpRequest $request) 
    {
        $quotationRevision = QuotationRevision::where('id', $request->quotation_revision_id)->first();

        $quotationRevision->status = $request->status;
        $quotationRevision->quotation->status = $request->status;
        $quotationRevision->quotation->save();
        $quotationRevision->save();
        
        //create a follow up
        $followUp = new FollowUp();
        $followUp->quotation_revision_id = $request->quotation_revision_id;
        $followUp->user_id = auth()->user()->id;
        $followUp->remark = $request->remark;
        $followUp->follow_up_time = $request->follow_up_time;
        $followUp->contact_person = $request->contact_person;
        $followUp->contact_number = $request->contact_number;
        $followUp->status = $request->status;

        $followUp->save();

        dispatch(new CompletingFollowUpJob($quotationRevision->quotation));

        return redirect()->route('admin.quotations.show',[$quotationRevision->quotation_id]);
    }

    public function edit(FollowUp $followUp)
    {
        abort_if(Gate::denies('follow_up_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $quotation_revisions = QuotationRevision::all()->pluck('quotation_revision', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $followUp->load('quotation_revision', 'user');

        return view('admin.followUps.edit', compact('quotation_revisions', 'users', 'followUp'));
    }

    public function update(UpdateFollowUpRequest $request, FollowUp $followUp)
    {
        $followUp->update($request->all());
        
        $followUp->quotation_revision->update(['status' => $request->status]);
        
        $followUp->quotation_revision->quotation->update(['status' => $request->status]);
        
        return redirect()->route('admin.quotations.show', $followUp->quotation_revision->quotation_id);
    }

    public function show(FollowUp $followUp)
    {
        abort_if(Gate::denies('follow_up_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followUp->load('quotation_revision', 'user');

        return view('admin.followUps.show', compact('followUp'));
    }

    public function destroy(FollowUp $followUp)
    {
        abort_if(Gate::denies('follow_up_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $followUp->delete();

        return back();
    }

    public function massDestroy(MassDestroyFollowUpRequest $request)
    {
        FollowUp::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
