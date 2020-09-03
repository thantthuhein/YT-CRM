<?php

namespace App\Exports;

use App\Exports\Sheets\EnquirySheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeExport;

class EnquiryExcelExport implements WithMultipleSheets 
{
    use Exportable;

    private $enquiries;

    public function __construct($airconTypes, $enquiries)
    {
        $this->airconTypes = $airconTypes;
        $this->enquiries = $enquiries; 
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[1] = new AirconTypesExport($this->airconTypes);
        $sheets[2] = new EnquirySheet($this->enquiries);

        return $sheets;
    }
}