<?php

namespace App\ValueObjects;

use Intervention\Image\EncodedImage;
use Native\Laravel\Facades\Settings;

class ConvertedImage
{
    public EncodedImage $converted;
    
    public string $name;
    
    public string $path;
    
    public function __construct(EncodedImage $converted, string $path) {
        $this->converted = $converted;        
        
        $this->name = pathinfo($path, PATHINFO_FILENAME).'.'.Settings::get('type', 'webp');  
             
        $this->path = dirname($path).'/'.$this->name;
    }
}