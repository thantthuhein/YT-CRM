<?php

namespace App\Exports;

use App\Exports\Sheets\QuotationSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class QuotationsExcelExport implements WithMultipleSheets
{
    use Exportable;

    private $quotations, $airconTypes;

    public function __construct($airconTypes, $quotations)
    {
        $this->airconTypes = $airconTypes; 
        $this->quotations = $quotations; 
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function sheets(): array
    {
        $sheets = [];

        $sheets[1] = new AirconTypesExport($this->airconTypes);
        $sheets[2] = new QuotationSheet($this->quotations);

        return $sheets;
    }
}
