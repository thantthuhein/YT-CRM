<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\Repair;
use App\Enquiry;
use App\Customer;
use App\Quotation;
use Carbon\Carbon;
use App\SaleContract;
use App\ServicingSetup;
use Illuminate\Http\Request;
use App\InHouseInstallation;
use App\Http\Controllers\Controller;
use App\Services\OverviewDataService;
use Symfony\Component\HttpFoundation\Response;

class HomeApiController extends Controller
{
    public function getData($months)
    {
        if ( $months == 'all-time') {
            /**
             * If request is for all time data, remove differences calculation
             */
            $data = collect([
                'inhouseInstallations', 
                'enquiries', 
                'successEnquiries', 
                'quotations', 
                'successQuotations', 
                'customers',
            ]);
            
            $data = $data->combine([
                collect([
                    'growthCount' => InHouseInstallation::count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),
        
                collect([
                    'growthCount' => Enquiry::count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),

                collect([
                    'growthCount' => Enquiry::success()->count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),

                collect([
                    'growthCount' => Quotation::count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),

                collect([
                    'growthCount' => Quotation::success()->count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),
        
                collect([
                    'growthCount' => Customer::count(),
                    'growthDifference' => 0,
                    'growthPercent' => 0,
                ]),                
            ]);
            
        } else {

            $data = OverviewDataService::fetchData($months);

        }

        return response($data);
    }        

    public function getOurGrowthByMonthData(Request $request)
    {        
        $calendarMonths = collect(config('calendarMonths'));
        
        for ($month = 1; $month <= 12 ; $month++) {             
            /**
             * Get Completed Sale Contracts Data
             */
            $saleContracts[] = SaleContract::whereMonth('created_at', $month)->get();
            
            /**
             * Get Completed Sale Inhouse Installations
             */
            $inhouseInstallations[] = InHouseInstallation::whereMonth('created_at', $month)
            ->get();

            /**
             * Get Completed Sale Servicing Setups
             */     
            $servicingSetups[] = ServicingSetup::whereMonth('created_at', $month)
            ->get();

            /**
             * Get Completed Repairs
             */
            $repairs[] = Repair::whereMonth('created_at', $month)->get();

        }

        $completedSaleContracts = $calendarMonths->combine($saleContracts);

        $completedInhouseInstallations = $calendarMonths->combine($inhouseInstallations);

        $completedServicingSetups = $calendarMonths->combine($servicingSetups);        

        $completedRepairs = $calendarMonths->combine($repairs);

        /**
         * Collection of all data
         */
        $data = collect([
            'saleContracts' => $completedSaleContracts,
            'inhouseinstallations' => $completedInhouseInstallations,
            'servicing' => $completedServicingSetups,
            'repair' => $completedRepairs,
        ]);

        return response($data);
    }

    public function getOurGrowthByYearData(Request $request)
    {
        $calendarCentury = config('calendarCentury');

        for ($year = 2019; $year <= 2030 ; $year++) {
            $saleContracts[] = SaleContract::whereYear('created_at', $year)->get();

            $inhouseInstallations[] = InHouseInstallation::whereYear('created_at', $year)
            ->get();

            $servicingSetups[] = ServicingSetup::whereYear('created_at', $year)
            ->get();

            $repairs[] = Repair::whereYear('created_at', $year)
            ->get();
        }

        $completedSaleContracts = collect($calendarCentury)->combine($saleContracts);

        $completedInhouseInstallations = collect($calendarCentury)->combine($inhouseInstallations);

        $completedServicingSetups = collect($calendarCentury)->combine($servicingSetups);        

        $completedRepairs = collect($calendarCentury)->combine($repairs);

        /**
         * Collection of all data
         */
        $data = collect([
            'saleContracts' => $completedSaleContracts,
            'inhouseinstallations' => $completedInhouseInstallations,
            'servicing' => $completedServicingSetups,
            'repair' => $completedRepairs,
        ]);

        return response($data);
    }
}
