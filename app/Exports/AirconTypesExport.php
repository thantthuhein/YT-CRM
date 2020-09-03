<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class AirconTypesExport implements FromCollection, WithMapping , WithHeadings, ShouldAutoSize, WithTitle, WithStrictNullComparison
{
    protected $airconTypes;

    public function __construct($airconTypes)
    {
        $this->airconTypes = $airconTypes;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection($this->airconTypes);
    }

    public function headings():array{
        return [
            'Aircon Type',
            'Count'
        ];
    }

    public function map($row): array
    {
        return [
            $row['type'],
            $row['count']
        ];
    }

    public function title():string
    {
        return 'Aircon Types';
    }

}
