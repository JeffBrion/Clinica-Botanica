<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class search-bar extends Component
{
    public string $table;
    /**
     * Create a new component instance.
     */
    public function __construct(String $table)
    {
        $this->table = $table;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search-bar');
    }
}
