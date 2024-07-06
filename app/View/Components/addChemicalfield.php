<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class addChemicalfield extends Component
{
    public $display;
    /**
     * Create a new component instance.
     */
    public function __construct($display)
    {
        $this->display = $display;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-chemicalfield');
    }
}