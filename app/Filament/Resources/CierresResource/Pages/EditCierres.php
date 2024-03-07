<?php

namespace App\Filament\Resources\CierresResource\Pages;

use App\Filament\Resources\CierresResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCierres extends EditRecord
{
    protected static string $resource = CierresResource::class;

    protected static ?string $title = 'Cierre';

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->label('Eliminar'),
        ];
    }
}
