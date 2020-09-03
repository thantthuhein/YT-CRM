<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class EnquirySheet implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithTitle
{
    protected $enquiries, $order;
    
    public function __construct($enquiries)
    {
        $this->enquiries = $enquiries; 
        $this->order = 1;       
    }

    public function headings():array{
        return [
            '#',
            'Created At',
            'Project',
            'Customer',
            'Company',
            'Location',
            'Air-con Types',
            'Receiver Name',
            'Status',
            'Created By'
        ];
    }

    public function map($enquiry):array{
        return [
            $this->order++,
            $enquiry->created_at->format('d-D-M-Y'),
            $enquiry->project->name ?? "N/A",
            $enquiry->customer->name,
            $enquiry->company->name ?? "N/A",
            $enquiry->location,
            implode(', ', $enquiry->airconTypes->pluck('type')->toArray()),
            $enquiry->receiver_name,
            $enquiry->status,
            $enquiry->created_by->name
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->enquiries;
    }

    public function title():string
    {
        return 'Enquiries';
    }
}
