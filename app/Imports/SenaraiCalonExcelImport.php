<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToArray;


class SenaraiCalonExcelImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        return $collection[0];
        // return new SheetImport();
    }
}

class SheetImport implements ToArray
{
    public function array(array $array)
    {
        // Handle the sheet data here, it is already converted into an array
        return $array;
    }
}
