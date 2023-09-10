<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Session\Session;

class NewAccountWidget extends Widget
{
    protected static ?int $sort = -3;
    protected static string $view = 'filament.widgets.new-account-widget';

    public $locale;

    public function mount() {
        $locale = app()->getLocale();
        $this->locale = $locale;
    }

    function changeLocale() {
        (new Session)->set('locale', $this->locale);
        App::setLocale($this->locale, app()->getLocale());
        
        // Reload Page
        redirect(request()->header('Referer'));
        return redirect(request()->header('Referer'));
    }
}