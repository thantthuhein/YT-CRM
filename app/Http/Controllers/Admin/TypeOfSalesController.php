<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeOfSaleRequest;
use App\Http\Requests\StoreTypeOfSaleRequest;
use App\Http\Requests\UpdateTypeOfSaleRequest;
use App\TypeOfSale;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeOfSalesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_of_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfSales = TypeOfSale::all();

        return view('admin.typeOfSales.index', compact('typeOfSales'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_of_sale_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeOfSales.create');
    }

    public function store(StoreTypeOfSaleRequest $request)
    {
        $typeOfSale = TypeOfSale::create($request->all());

        return redirect()->route('admin.type-of-sales.index');
    }

    public function edit(TypeOfSale $typeOfSale)
    {
        abort_if(Gate::denies('type_of_sale_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeOfSales.edit', compact('typeOfSale'));
    }

    public function update(UpdateTypeOfSaleRequest $request, TypeOfSale $typeOfSale)
    {
        $typeOfSale->update($request->all());

        return redirect()->route('admin.type-of-sales.index');
    }

    public function show(TypeOfSale $typeOfSale)
    {
        abort_if(Gate::denies('type_of_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.typeOfSales.show', compact('typeOfSale'));
    }

    public function destroy(TypeOfSale $typeOfSale)
    {
        abort_if(Gate::denies('type_of_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfSale->delete();

        return back();
    }

    public function massDestroy(MassDestroyTypeOfSaleRequest $request)
    {
        TypeOfSale::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
