<?php

namespace App\Exports;

use App\Exports\Sheets\SaleContractSheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SaleContractExport implements WithMultipleSheets
{
    private $saleContracts, $airconTypes;

    public function __construct($airconTypes, $saleContracts)
    {
        $this->airconTypes = $airconTypes;
        $this->saleContracts = $saleContracts;  
        $this->order = 1;       
    }

    public function sheets(): array
    {
        $sheets = [];

        $sheets[1] = new AirconTypesExport($this->airconTypes);
        $sheets[2] = new SaleContractSheet($this->saleContracts);

        return $sheets;
    }
}
