<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\currentStock;

class stockCurrent extends Component
{
    public $selectCurrentStock;
    /**
     * Create a new component instance.
     */
    public function __construct($selectCurrentStock)
    {
        $this->selectCurrentStock = $selectCurrentStock;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.stock-current');
    }
}
