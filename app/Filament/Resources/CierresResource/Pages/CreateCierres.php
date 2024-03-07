<?php

namespace App\Filament\Resources\CierresResource\Pages;

use App\Filament\Resources\CierresResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCierres extends CreateRecord
{
    protected static string $resource = CierresResource::class;

    protected static ?string $title = 'Cierre';

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

}
