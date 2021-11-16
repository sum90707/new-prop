<?php

namespace App\Exports;

use App\Paper;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class PaperExport implements FromCollection
{
    protected $queistions;

    public function __construct(array $queistions)
    {
        $this->queistions = $queistions;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return new Collection($this->queistions);
    }
}
