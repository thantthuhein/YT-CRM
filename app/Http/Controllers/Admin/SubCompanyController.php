<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubCompanyRequest;
use App\Http\Requests\StoreSubCompanyRequest;
use App\Http\Requests\UpdateSubCompanyRequest;
use App\SubCompany;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubCompanyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompanies = SubCompany::paginate(10);

        return view('admin.subCompanies.index', compact('subCompanies'));
    }

    public function create()
    {
        abort_if(Gate::denies('sub_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.subCompanies.create', compact('created_bies', 'updated_bies'));
    }

    public function store(StoreSubCompanyRequest $request)
    {
        $datas = $request->all();
        $datas['created_by_id'] = Auth::id();

        $subCompany = SubCompany::create($datas);

        return redirect()->route('admin.sub-companies.index');
    }

    public function edit(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $updated_bies = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $subCompany->load('created_by', 'updated_by');

        return view('admin.subCompanies.edit', compact('created_bies', 'updated_bies', 'subCompany'));
    }

    public function update(UpdateSubCompanyRequest $request, SubCompany $subCompany)
    {
        $subCompany->update($request->all());

        return redirect()->route('admin.sub-companies.index');
    }

    public function show(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompany->load('created_by', 'updated_by');      

        $subconInstallations = $subCompany->subComInstallations()->whereHas('sale_contract')->paginate(10);

        return view('admin.subCompanies.show', compact('subCompany', 'subconInstallations'));
    }

    public function destroy(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroySubCompanyRequest $request)
    {
        SubCompany::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    
}
