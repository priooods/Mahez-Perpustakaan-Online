<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    public $tableTitle;
    public $tableDesc;
    public $usefilter;
    public $filtering;
    public $column;
    public $row;
    public $formLink;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $tableTitle, 
        string $tableDesc, 
        bool $usefilter,
        array $column,
        $row,
        string $formLink, 
        $filtering = null,
    )
    {
        $this->tableTitle = $tableTitle;
        $this->tableDesc = $tableDesc;
        $this->usefilter = $usefilter;
        $this->filtering = $filtering;
        $this->column = $column;
        $this->row = $row;
        $this->formLink = $formLink;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.table');
    }
}
