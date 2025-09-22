<?php

namespace App\View\Components\common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Notification as NotificationModel;

class Notification extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public NotificationModel $detail,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.notification');
    }
}
