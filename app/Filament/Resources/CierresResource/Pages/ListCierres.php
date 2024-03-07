<?php

namespace App\Filament\Resources\CierresResource\Pages;

use App\Filament\Resources\CierresResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCierres extends ListRecords
{
    protected static string $resource = CierresResource::class;

    protected static ?string $title = 'Cierres diarios';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nuevo'),
        ];
    }
}
