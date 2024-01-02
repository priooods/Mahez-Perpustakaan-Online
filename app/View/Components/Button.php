<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public $variant = 'blue' | 'red' | 'emerald' | 'yellow';
    public $label;
    public $iswrap;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($variant = 'blue', $label = '', $iswrap = false)
    {
        $this->variant = $variant;
        $this->label = $label;
        $this->iswrap = $iswrap;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
