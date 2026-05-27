<?php

namespace App\Filament\Forms\Components;

use App\Helpers\Jalali;
use Filament\Forms\Components\Field;

class JalaliDatePicker extends Field
{
    protected string $view = 'filament.forms.components.jalali-date-picker';

    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->afterStateHydrated(function (self $component, $state): void {
                if ($state) {
                    $component->state(Jalali::format($state, 'Y/m/d'));
                }
            })
            ->dehydrateStateUsing(function ($state): ?string {
                if (!$state) return null;
                return Jalali::toGregorianString($state);
            });
    }
}
