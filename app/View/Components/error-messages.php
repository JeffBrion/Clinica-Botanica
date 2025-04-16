<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class error-messages extends Component
{
    public $errors;
    /**
     * Create a new component instance.
     */
    public function __construct($errors = ['Ha ocurrido un error'])
    {
        $this->errors = $errors;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.error-messages');
    }
}
