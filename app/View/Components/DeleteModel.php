<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeleteModel extends Component
{
    public $modelId, $Action;
    /**
     * Create a new component instance.
     */
    public function __construct($modelId, $Action)
    {
        $this->modelId = $modelId;
        $this->Action = $Action;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.delete-model');
    }
}