<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $inputType = 'text' | 'textarea' | 'number' | 'select';
    public $label;
    public $selectOptions;
    public $defaulttextarea;
    public $acceptFile;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(string $label = '', string $inputType = 'text',
        $selectOptions = [], $acceptFile = "*", $defaulttextarea = null)
    {
        $this->label = $label;
        $this->defaulttextarea = $defaulttextarea;
        $this->acceptFile = $acceptFile;
        $this->selectOptions = $selectOptions;
        $this->inputType = $inputType;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.input');
    }
}
