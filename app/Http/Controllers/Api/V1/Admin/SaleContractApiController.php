<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleContractRequest;
use App\Http\Requests\UpdateSaleContractRequest;
use App\Http\Resources\Admin\SaleContractResource;
use App\SaleContract;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SaleContractApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sale_contract_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaleContractResource(SaleContract::with(['created_by', 'updated_by'])->get());
    }

    public function store(StoreSaleContractRequest $request)
    {
        $saleContract = SaleContract::create($request->all());

        return (new SaleContractResource($saleContract))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SaleContract $saleContract)
    {
        abort_if(Gate::denies('sale_contract_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SaleContractResource($saleContract->load(['created_by', 'updated_by']));
    }

    public function update(UpdateSaleContractRequest $request, SaleContract $saleContract)
    {
        $saleContract->update($request->all());

        return (new SaleContractResource($saleContract))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SaleContract $saleContract)
    {
        abort_if(Gate::denies('sale_contract_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $saleContract->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getCompletedSaleContractsByMonth(Request $request)
    {        
        $calendarMonths = collect(config('calendarMonths'));

        for ($month = 1; $month <= 12 ; $month++) {             
            $saleContracts[] = SaleContract::whereHas('inHouseInstallation', function($query) use($month) {
                $query->whereMonth('approved_at', $month)->where('status', 'approved');
            })->get();
        }

        $completedSaleContracts = $calendarMonths->combine($saleContracts);
        
        return response($completedSaleContracts);
    }
}
