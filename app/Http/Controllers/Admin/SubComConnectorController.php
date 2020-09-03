<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubComConnectorRequest;
use App\Http\Requests\StoreSubComConnectorRequest;
use App\Http\Requests\UpdateSubComConnectorRequest;
use App\SubComConnector;
use App\SubComInstallation;
use App\SubCompany;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubComConnectorController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_com_connector_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComConnectors = SubComConnector::all();

        return view('admin.subComConnectors.index', compact('subComConnectors'));
    }

    public function create()
    {
        abort_if(Gate::denies('sub_com_connector_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_coms = SubCompany::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sub_com_installations = SubComInstallation::all()->pluck('rating', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subComConnectors.create', compact('sub_coms', 'sub_com_installations'));
    }

    public function store(StoreSubComConnectorRequest $request)
    {
        $subComConnector = SubComConnector::create($request->all());

        return redirect()->route('admin.sub-com-connectors.index');
    }

    public function edit(SubComConnector $subComConnector)
    {
        abort_if(Gate::denies('sub_com_connector_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sub_coms = SubCompany::all()->pluck('company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sub_com_installations = SubComInstallation::all()->pluck('rating', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subComConnector->load('sub_com', 'sub_com_installation');

        return view('admin.subComConnectors.edit', compact('sub_coms', 'sub_com_installations', 'subComConnector'));
    }

    public function update(UpdateSubComConnectorRequest $request, SubComConnector $subComConnector)
    {
        $subComConnector->update($request->all());

        return redirect()->route('admin.sub-com-connectors.index');
    }

    public function show(SubComConnector $subComConnector)
    {
        abort_if(Gate::denies('sub_com_connector_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComConnector->load('sub_com', 'sub_com_installation');

        return view('admin.subComConnectors.show', compact('subComConnector'));
    }

    public function destroy(SubComConnector $subComConnector)
    {
        // admin.sub-com-connectors
        abort_if(Gate::denies('sub_com_connector_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subComConnector->delete();

        return back();
    }

    public function massDestroy(MassDestroySubComConnectorRequest $request)
    {
        SubComConnector::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
