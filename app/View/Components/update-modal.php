<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class update-modal extends Component
{
    public $fields;
    public $modal_id;

    public function __construct(Array $fields = [], $modal_id = 'update_modal')
    {
        $this->fields = $fields;
        $this->modal_id = $modal_id;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.update-modal');
    }
}
