<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FilterBar extends Component
{
    /**
     * Create a new component instance.
     */
    public $search;
    public $type;
    public $date;
    public $time;
    public $duration;

    public function __construct(
        $search = '',
        $type = 'Semua',
        $date = 'Min, 23 Des',
        $time = '15:00',
        $duration = '1 hari'
    )
    {
        $this->search = $search;
        $this->type = $type;
        $this->date = $date;
        $this->time = $time;
        $this->duration = $duration;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.filter-bar');
    }
}
