<?php

namespace App\Providers;

use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\Menu;
use App\Events\ConvertItemClicked;
use App\Events\QualityItemClicked;
use App\Events\ZipItemClicked;
use Native\Laravel\Facades\Settings;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {       
        MenuBar::create()
            ->onlyShowContextMenu()
            ->withContextMenu(
                Menu::make(
                    Menu::make(
                        $this->qualityItem('20'),
                        $this->qualityItem('40'),
                        $this->qualityItem('60'),
                        $this->qualityItem('80'),
                        $this->qualityItem('100', true),
                    )->label('Quality'),
                    Menu::checkbox('Save as zip')->event(ZipItemClicked::class),
                    Menu::separator(),
                    Menu::label('Convert')->event(ConvertItemClicked::class),
                    Menu::separator(),
                    Menu::quit()
                )
            );            
    }

    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [
        ];
    }
    
    public function qualityItem(string $value, bool $default = false)
    {        
        return Menu::radio($value.'%', checked: Settings::get('quality', $default ? $value : null) === $value )
            ->event(QualityItemClicked::class);
    }
}