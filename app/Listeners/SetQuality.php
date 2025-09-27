<?php

namespace App\Listeners;

use App\Events\QualityItemClicked;
use Native\Laravel\Facades\Settings;

class SetQuality
{
    public function handle(QualityItemClicked $event): void
    {
        $value = $event->item['label'];
       
        Settings::set('quality', trim($value, '%'));
    }
}