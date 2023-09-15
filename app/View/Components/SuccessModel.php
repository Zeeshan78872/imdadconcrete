<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SuccessModel extends Component
{
    public $title;
    public $desc;
    public $closeText;


    public function __construct($title, $desc, $closeText)
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->closeText = $closeText;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.success-model');
    }
}