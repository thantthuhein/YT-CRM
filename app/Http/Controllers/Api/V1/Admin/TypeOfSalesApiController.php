<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeOfSaleRequest;
use App\Http\Requests\UpdateTypeOfSaleRequest;
use App\Http\Resources\Admin\TypeOfSaleResource;
use App\TypeOfSale;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypeOfSalesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_of_sale_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfSaleResource(TypeOfSale::all());
    }

    public function store(StoreTypeOfSaleRequest $request)
    {
        $typeOfSale = TypeOfSale::create($request->all());

        return (new TypeOfSaleResource($typeOfSale))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TypeOfSale $typeOfSale)
    {
        abort_if(Gate::denies('type_of_sale_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeOfSaleResource($typeOfSale);
    }

    public function update(UpdateTypeOfSaleRequest $request, TypeOfSale $typeOfSale)
    {
        $typeOfSale->update($request->all());

        return (new TypeOfSaleResource($typeOfSale))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TypeOfSale $typeOfSale)
    {
        abort_if(Gate::denies('type_of_sale_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $typeOfSale->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
