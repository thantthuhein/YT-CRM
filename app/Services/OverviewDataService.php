<?php

namespace App\Services;

class OverviewDataService {

    public static function fetchData($months)
    {                
        $data = collect([
            'inhouseInstallations', 
            'enquiries', 
            'successEnquiries', 
            'quotations', 
            'successQuotations', 
            'customers',
        ]);

        $data = $data->combine([
            static::calculate($months, 'App\InHouseInstallation'),
            static::calculate($months, 'App\Enquiry'),
            static::calculate($months, 'App\Enquiry', true),
            static::calculate($months, 'App\Quotation'),
            static::calculate($months, 'App\Quotation', true),
            static::calculate($months, 'App\Customer'),
        ]);

        return $data;
    }

    public static function calculate($months, $type, $useScope = NULL)
    {
        if ( $useScope == TRUE) {            

            $growthCount = $type::success()
            ->where('created_at', '>', today()->subMonths($months))
            ->count(); 

        } else {
            $growthCount = $type::where('created_at', '>', today()->subMonths($months))->count(); 
        }
        
        $current = today()->subMonths($months);        
        $before = today()->subMonths($months * 2);

        $beforeCurrentPeriod = $type::whereBetween('created_at', [$before, $current])->count();

        $growthDifference = $growthCount - $beforeCurrentPeriod;

        if ($beforeCurrentPeriod == 0) {

            if ($beforeCurrentPeriod == $growthCount) {
                $growthPercent = 0;
            } else {
                $growthPercent = 100;
            }            

        } else {
            $growthPercent = $growthDifference / ( $beforeCurrentPeriod / 100 );
        } 

        return $collection = collect([
            'growthCount' => $growthCount,
            'growthDifference' => $growthDifference,
            'growthPercent' => (int) $growthPercent,
        ]);
    }
}