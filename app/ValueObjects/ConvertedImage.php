<?php

namespace App\ValueObjects;

use Intervention\Image\EncodedImage;

class ConvertedImage
{
    public EncodedImage $converted;
    
    public string $name;
    
    public string $path;
    
    public function __construct(EncodedImage $converted, string $path) {
        $this->converted = $converted;        
        
        $this->name = pathinfo($path, PATHINFO_FILENAME).'.webp';  
             
        $this->path = dirname($path).'/'.$this->name;
    }
}