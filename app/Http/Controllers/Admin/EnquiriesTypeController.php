<?php

namespace App\Http\Controllers\Admin;

use App\EnquiriesType;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEnquiriesTypeRequest;
use App\Http\Requests\StoreEnquiriesTypeRequest;
use App\Http\Requests\UpdateEnquiriesTypeRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnquiriesTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('enquiries_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiriesTypes = EnquiriesType::all();

        return view('admin.enquiriesTypes.index', compact('enquiriesTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('enquiries_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enquiriesTypes.create');
    }

    public function store(StoreEnquiriesTypeRequest $request)
    {
        $enquiriesType = EnquiriesType::create($request->all());

        return redirect()->route('admin.enquiries-types.index');
    }

    public function edit(EnquiriesType $enquiriesType)
    {
        abort_if(Gate::denies('enquiries_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enquiriesTypes.edit', compact('enquiriesType'));
    }

    public function update(UpdateEnquiriesTypeRequest $request, EnquiriesType $enquiriesType)
    {
        $enquiriesType->update($request->all());

        return redirect()->route('admin.enquiries-types.index');
    }

    public function show(EnquiriesType $enquiriesType)
    {
        abort_if(Gate::denies('enquiries_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.enquiriesTypes.show', compact('enquiriesType'));
    }

    public function destroy(EnquiriesType $enquiriesType)
    {
        abort_if(Gate::denies('enquiries_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $enquiriesType->delete();

        return back();
    }

    public function massDestroy(MassDestroyEnquiriesTypeRequest $request)
    {
        EnquiriesType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
