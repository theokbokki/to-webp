<?php

namespace App\Listeners;

use App\Events\ZipItemClicked;
use Native\Laravel\Facades\Settings;

class SetZip
{
    public function handle(ZipItemClicked $event): void
    {
        Settings::set('zip', $event->item['checked']);
    }
}