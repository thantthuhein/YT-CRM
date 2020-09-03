<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class QuotationSheet implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
{
    private $quotations, $order;

    public function __construct($quotations)
    {
        $this->quotations = $quotations; 
        $this->order = 1;
    }

    public function headings():array{
        return [
            '#',
            'Project',
            'Customer',
            'Company',
            'Location',
            'Air-con Types',
            'Quotation Number',
            'Status',
            'Created By',
            'Last Quotated Date',
            'Last Revision PDF',
            'Last Follow Up Date',
            'Contact Person',
            'Last Follow Up Remark',
        ];
    }

    public function map($quotation):array{
        return [
            $this->order++,
            $quotation->enquiries->first()->project->name ?? "N/A",
            $quotation->customer->name,
            $quotation->enquiries->first()->company->name ?? "N/A",
            $quotation->enquiries->first()->location,
            implode(', ', $quotation->enquiries->first()->airconTypes->pluck('type')->toArray()),
            $quotation->number,
            $quotation->status,
            $quotation->created_by->name,
            $quotation->quotationRevisions->last()->quoted_date ?? "N/A",
            $quotation->quotationRevisions->last()->quotation_pdf ?? "N/A",
            $quotation->quotationRevisions->last()->followUps->last()->follow_up_time ?? "N/A",
            $quotation->quotationRevisions->last()->followUps->last()->contact_person ?? "N/A",
            $quotation->quotationRevisions->last()->followUps->last()->remark ?? "",
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->quotations;
    }

    public function title():string
    {
        return "Quotations";
    }
}