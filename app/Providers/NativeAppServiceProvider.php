<?php

namespace App\Providers;

use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\Menu;
use App\Events\ConvertItemClicked;

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
                        Menu::make(
                            Menu::radio('20%'),
                            Menu::radio('40%'),
                            Menu::radio('60%'),
                            Menu::radio('80%'),
                            Menu::radio('100%')->checked(),
                        )->label('Quality'),
                    )->label('Settings'),
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
}