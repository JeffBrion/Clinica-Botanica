<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class sub-navbar extends Component
{
    public $links = [];
    /**
     * Create a new component instance.
     */
    public function __construct(Array $links = [])
    {
        $this->links = $links;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sub-navbar');
    }
}
