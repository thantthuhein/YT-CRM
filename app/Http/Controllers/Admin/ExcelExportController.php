<?php

namespace App\Http\Controllers\Admin;

use App\AirconType;
use App\Enquiry;
use App\Quotation;
use App\RemainingJob;
use App\SaleContract;
use Illuminate\Http\Request;
use App\Exports\EnquiryExcelExport;
use App\Exports\SaleContractExport;
use Illuminate\Support\Facades\Log;
use App\Exports\RemainingJobsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\QuotationsExcelExport;
use App\Exports\Sheets\SaleContractSheet;

class ExcelExportController extends Controller
{
    public function index(Request $request)
    {
        $airconTypes = AirconType::pluck('type', 'id');

        $models = [
            'enquiry' => 'Enquiry',
            'quotation' => 'Quotation',
            'sale_contract' => 'Sales Contract'
        ];

        $type = ($request->has('type') && array_key_exists($request->type, $models)) ? $request->type : 'enquiry';

        $enquiries = collect([]);
        $quotations = collect([]);
        $saleContracts = collect([]);

        $dateRange = $request->has('from') && $request->from != null && $request->has('to') && $request->has('to') != null;

        $airconTypeArrays = [];

        if($type == 'enquiry')
        {
            $enquiries = Enquiry::when($dateRange, function($query) use($request){
                                        $query->whereBetween('created_at', [$request->from, $request->to]);
                                    })
                                    ->with(
                                        'saleContract', 
                                        'airconTypes', 
                                        'quotations', 
                                        'enquiries_type',
                                        'type_of_sales',
                                        'company',
                                        'project',
                                        'created_by'
                                    );
            $airconCount = $enquiries->get()->pluck('airconTypes.*.id')->flatten()->countBy()->all();
            
            foreach($airconTypes as $index => $airconType){
                $array = [];
                $array['type'] = $airconType;
                if(array_key_exists($index, $airconCount)){
                    $array['count'] = $airconCount[$index];
                }
                else{
                    $array['count'] = 0;
                }
                array_push($airconTypeArrays, $array);
            }

            if($request->has('export') && $enquiries->count() > 0){
                return (new EnquiryExcelExport($airconTypeArrays, $enquiries->cursor()))->download('Enquiries.xlsx');
            }

            $enquiries = $enquiries->paginate(10);

        }
        elseif($type == 'quotation')
        {
            $quotations = Quotation::when($dateRange, function($query) use($request){
                                        $query->whereBetween('created_at', [$request->from, $request->to]);
                                    })
                                    ->with(
                                        'quotationRevisions',
                                        'customer',
                                        'enquiries',
                                        'created_by',
                                        'quotationRevisions.followUps'
                                    );

            $airconCount = $quotations->get()->pluck('enquiries.airconTypes.*.id')->flatten()->countBy()->all();

            foreach($airconTypes as $index => $airconType){
                $array = [];
                $array['type'] = $airconType;
                if(array_key_exists($index, $airconCount)){
                    $array['count'] = $airconCount[$index];
                }
                else{
                    $array['count'] = 0;
                }
                array_push($airconTypeArrays, $array);
            }

            if($request->has('export') && $quotations->count() > 0){
                return Excel::download(new QuotationsExcelExport($airconTypeArrays, $quotations->cursor()), 'Quotations.xlsx');
            }
            $quotations = $quotations->paginate(10);
        }
        else{
            $saleContracts = SaleContract::when($dateRange, function($query) use($request){
                                                $query->whereBetween('created_at', [$request->from, $request->to]);
                                            })
                                            ->with( 
                                                'morphableEnquiryQuotation',
                                                'inHouseInstallation',
                                                'created_by'
                                                  );
            $airconCount = $saleContracts->get()->pluck('enquiry.airconTypes.*.id')->flatten()->countBy()->all();            
                                                  
            foreach($airconTypes as $index => $airconType){
                $array = [];
                $array['type'] = $airconType;
                if(array_key_exists($index, $airconCount)){
                    $array['count'] = $airconCount[$index];
                }
                else{
                    $array['count'] = 0;
                }
                array_push($airconTypeArrays, $array);
            }
            if($request->has('export') && $saleContracts->count() > 0){
                return Excel::download(new SaleContractExport($airconTypeArrays, $saleContracts->cursor()), 'SaleContracts.xlsx');
            }                              
            $saleContracts = $saleContracts->paginate(10);
        }
        return view('admin.excelExports.index', compact('models', 'type', 'enquiries', 'quotations', 'saleContracts'));
    }

    public function saleContracts(Request $request){
        $saleContracts = SaleContract::with('morphableEnquiryQuotation')->get();

        return Excel::download(new SaleContractSheet($saleContracts), "SaleContracts.xlsx");
    }

    public function remainingJobs(Request $request){
        
        if ($request->has('for') && ! empty($request->for) && $request->for == 'today') {
            $remainingJobs = RemainingJob::where('created_at', today())->get();

        } else {
            $remainingJobs = RemainingJob::all();

        }
        // dd($remainingJobs);

        return Excel::download(new RemainingJobsExport($remainingJobs), "RemainingJobs.xlsx");
    }
}
