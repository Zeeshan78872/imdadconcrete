<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AddProductSize extends Component
{
    public $display, $count;
    /**
     * Create a new component instance.
     */
    public function __construct($display, $count)
    {
        $this->display = $display;
        $this->count = $count;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.add-product-size');
    }
}