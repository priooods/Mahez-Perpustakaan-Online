<?php

namespace App\Exports;

use App\Models\book\TBookTab;
use Maatwebsite\Excel\Concerns\FromCollection;
class BookExport implements FromCollection
{
    public function __construct($access,$userid)
    {
        $this->access = $access;
        $this->userid = $userid;
    }
    /**
    // * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if($this->access == 1){
            return TBookTab::all();
        } 
        return TBookTab::where('user_tabs_id',$this->userid)->get();
    }
}
