<?php

namespace App\Listeners;

use App\Events\ConvertItemClicked;
use Native\Laravel\Dialog;
use Intervention\Image\ImageManager;
use Native\Laravel\Facades\Settings;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\ValueObjects\ConvertedImage;
use Exception;

class Convert
{
    public function handle(ConvertItemClicked $event): void
    {   
        $files = $this->selectFiles();
        
        $converted = $this->convertFiles($files);
        
        $this->saveFiles($converted);
    }
    
    protected function selectFiles(): array
    {
        return Dialog::new()
            ->multiple()
    	    ->open();
    }
    
    protected function convertFiles(array $files): array
    {              		
    	$manager = ImageManager::gd();
    	
        return array_map(function (string $path) use ($manager) {
            $image = $manager->read($path);
            
            $converted = $image->encodeByExtension(Settings::get('type', 'webp'), Settings::get('quality', 100));
            
            return new ConvertedImage($converted, $path);
        }, $files);
    }
    
    protected function saveFiles(array $files): void
    {
        Settings::get('zip') 
            ? $this->saveAsZip($files) 
            : $this->saveAsFile($files);
    }
    
    protected function saveAsZip(array $files): void
    {
        $zip = $this->createZipArchive();
                    
        foreach ($files as $file) {
            $zip->addFromString($file->name, $file->converted);
        }
        
        $zip->close();
    }
    
    protected function saveAsFile(array $files): void
    {
        foreach ($files as $file) {
            $file->converted->save($file->path);
        }
    }
    
    protected function createZipArchive(): ZipArchive
    {
        $zip = new ZipArchive();
        $zipName = "to-webp.zip";
            
        if ($zip->open(Storage::disk('downloads')->path($zipName), ZipArchive::CREATE) !== TRUE) {
            throw new Exception('Couldn\' create zip file');
        }
        
        return $zip;
    }
}