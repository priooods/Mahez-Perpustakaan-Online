<?php

namespace App\Exports;

use App\Models\book\TBookTab;
use Maatwebsite\Excel\Concerns\FromCollection;
class BookExport implements FromCollection
{
    /*
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return TBookTab::all();
    }
}
