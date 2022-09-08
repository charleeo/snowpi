<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StateImport implements WithStartRow
{
    /**
    * @param WithStartRow $collection
    */
    public function startRow(): int
    {
        return 2;
    }
}
