<?php

namespace App\Listeners;

use App\Events\ConvertItemClicked;
use Native\Laravel\Dialog;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;

class Convert
{
    public function handle(ConvertItemClicked $event): void
    {
        $results = Dialog::new()
            ->multiple()
    	    ->open();
    		
    	$manager = new ImageManager(new Driver());
        
        foreach ($results as $path) {
            $image = $manager->read($path);
            
            $encoded = $image->encode(new WebpEncoder(quality: 80));
            
            $encoded->save(dirname($path).'/'.pathinfo($path, PATHINFO_FILENAME).'.webp');
        }	
    }
}