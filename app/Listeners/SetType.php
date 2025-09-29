<?php

namespace App\Listeners;

use App\Events\TypeItemClicked;
use Native\Laravel\Facades\Settings;

class SetType
{
    public function handle(TypeItemClicked $event): void
    {
        Settings::set('type', $event->item['label']);
    }
}