<?php

namespace App\View\Components\Exports;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class printBtn extends Component
{
    public function __construct(
        public string $viewName,
        public $params = null,
        public $title = null,
        public $pageProperties = null
    ) {
        $this->pageProperties = isset($pageProperties) ? base64_encode(serialize($pageProperties)) : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.exports.print-btn');
    }
}