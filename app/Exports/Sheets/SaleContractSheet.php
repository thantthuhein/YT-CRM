<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class SaleContractSheet implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
{
    private $saleContracts, $order;

    public function __construct($saleContracts)
    {
        $this->saleContracts = $saleContracts;  
        $this->order = 1;       
    }

    public function headings():array{
        return [
            '#',
            'Project',
            'Customer',
            'Company',
            'Air-con Types',
            'Quotation Number',
            'Last Quotated Date',
            'Last Revision PDF',
            'Installation Type',
            'Payment',
            'Payment Status',
            'Created By'
        ];
    }

    public function map($saleContract):array{
        $hasQuotation = false;
        if($saleContract->morphableName == 'Quotation')
        {
            $hasQuotation = true;
        }
        return [
            $this->order++,
            $saleContract->project->name ?? "N/A",
            $saleContract->customer->name,
            $saleContract->company->name ?? "N/A",
            implode(', ', $saleContract->airconTypes->pluck('type')->toArray()),
            $hasQuotation ? $saleContract->morphableEnquiryQuotation->number : "NONE",
            $hasQuotation ? ($saleContract->morphableEnquiryQuotation->quotationRevisions->last()->quoted_date ?? "N/A") : "NONE",
            $hasQuotation ? ($saleContract->morphableEnquiryQuotation->quotationRevisions->last()->quotation_pdf ?? "N/A") : "NONE",
            $saleContract->installation_type,
            $saleContract->current_payment_step .'/' .$saleContract->payment_terms,
            $saleContract->payment_status ?? 'NULL',
            $saleContract->created_by->name            
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->saleContracts;
    }

    public function title():string
    {
        return 'Sale Contracts';
    }
}