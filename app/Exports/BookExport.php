<?php

namespace App\Exports;

use App\Models\book\TBookTab;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\Exportable;
class BookExport implements Responsable,FromArray
{
    use Exportable;
    public function __construct(array $query)
    {
        $this->query = $query;
    }
    /**
    // * @return \Illuminate\Support\Collection
    */
    public function array(): array
    {
        return $this->query;
    }
}
