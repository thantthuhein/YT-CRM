<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyServicingSetupRemarkRequest;
use App\Http\Requests\StoreServicingSetupRemarkRequest;
use App\Http\Requests\UpdateServicingSetupRemarkRequest;
use App\ServicingSetup;
use App\ServicingSetupRemark;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServicingSetupRemarkController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('servicing_setup_remark_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetupRemarks = ServicingSetupRemark::all();

        return view('admin.servicingSetupRemarks.index', compact('servicingSetupRemarks'));
    }

    public function create()
    {
        abort_if(Gate::denies('servicing_setup_remark_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_setups = ServicingSetup::all()->pluck('is_major', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.servicingSetupRemarks.create', compact('servicing_setups'));
    }

    public function store(StoreServicingSetupRemarkRequest $request)
    {
        $servicingSetupRemark = ServicingSetupRemark::create($request->all());
        
        return redirect()->back();
    }

    public function edit(ServicingSetupRemark $servicingSetupRemark)
    {
        abort_if(Gate::denies('servicing_setup_remark_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicing_setups = ServicingSetup::all()->pluck('is_major', 'id')->prepend(trans('global.pleaseSelect'), '');

        $servicingSetupRemark->load('servicing_setup');

        return view('admin.servicingSetupRemarks.edit', compact('servicing_setups', 'servicingSetupRemark'));
    }

    public function update(UpdateServicingSetupRemarkRequest $request, ServicingSetupRemark $servicingSetupRemark)
    {
        $userId = auth()->user()->id;
        $servicingSetupRemark->update([
            'remark' => $request->remark,
            'updated_by_id' => $userId
        ]);

        return redirect()->route('admin.servicing-setups.show', [$servicingSetupRemark->servicing_setup]);
    }

    public function show(ServicingSetupRemark $servicingSetupRemark)
    {
        abort_if(Gate::denies('servicing_setup_remark_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetupRemark->load('servicing_setup');

        return view('admin.servicingSetupRemarks.show', compact('servicingSetupRemark'));
    }

    public function destroy(ServicingSetupRemark $servicingSetupRemark)
    {
        abort_if(Gate::denies('servicing_setup_remark_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $servicingSetupRemark->delete();

        return back();
    }

    public function massDestroy(MassDestroyServicingSetupRemarkRequest $request)
    {
        ServicingSetupRemark::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
