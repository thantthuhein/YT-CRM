<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubComInstallationRequest;
use App\Http\Requests\StoreSubComInstallationRequest;
use App\Http\Requests\UpdateSubComInstallationRequest;
use App\SaleContract;
use App\SubComInstallation;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubComInstallationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_com_installation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComInstallations = SubComInstallation::all();

        return view('admin.subComInstallations.index', compact('subComInstallations'));
    }

    public function create()
    {
        abort_if(Gate::denies('sub_com_installation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sale_contracts = SaleContract::all()->pluck('has_installation', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subComInstallations.create', compact('sale_contracts'));
    }

    public function store(StoreSubComInstallationRequest $request)
    {
        $subComInstallation = SubComInstallation::create($request->all());

        return redirect()->route('admin.sub-com-installations.index');
    }

    public function edit(SubComInstallation $subComInstallation)
    {
        abort_if(Gate::denies('sub_com_installation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComInstallation->load('sale_contract');

        return view('admin.subComInstallations.edit', compact('subComInstallation'));
    }

    public function update(UpdateSubComInstallationRequest $request, SubComInstallation $subComInstallation)
    {
        $subComInstallation->update($request->all());

        return redirect()->route('admin.sale-contracts.show', [$subComInstallation->sale_contract]);
    }

    public function show(SubComInstallation $subComInstallation)
    {
        abort_if(Gate::denies('sub_com_installation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComInstallation->load('sale_contract');

        return view('admin.subComInstallations.show', compact('subComInstallation'));
    }

    public function destroy(SubComInstallation $subComInstallation)
    {
        abort_if(Gate::denies('sub_com_installation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComInstallation->delete();

        return back();
    }

    public function massDestroy(MassDestroySubComInstallationRequest $request)
    {
        SubComInstallation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
