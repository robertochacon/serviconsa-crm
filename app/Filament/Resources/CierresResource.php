<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CierresResource\Pages;
use App\Filament\Resources\CierresResource\RelationManagers;
use App\Models\Closing;
use App\Models\Provider;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class CierresResource extends Resource
{
    protected static ?string $model = Closing::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cierres';

    protected static ?string $navigationLabel = 'Cierres diarios';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Cierre del dia')
                        ->schema([
                            Section::make()
                            ->schema([
                                Section::make()
                                ->schema([
                                    Select::make('provider')->label('Proveedor')
                                    ->options(Provider::all()->pluck('name','name'))
                                    ->searchable(['name'])
                                    ->required(),
                                    DatePicker::make('date')->label("Fecha"),
                                ])->columns(2),
                                Repeater::make('services')->label('Servicios')
                                ->schema([
                                    TextInput::make('place')->label('Lugar'),
                                    TextInput::make('do')->numeric()->label('Pesos por metro')
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, Get $get){
                                        $total = ($state * $get('meters'));
                                        $set('total', number_format($total,2));
                                    }),
                                    TextInput::make('meters')->numeric()->label('Cantidad de metros')
                                    ->minValue(1)
                                    ->reactive()
                                    ->afterStateUpdated(function ($state, callable $set, Get $get){
                                        $total = ($state * $get('do'));
                                        $set('total', number_format($total,2));
                                    }),
                                    TextInput::make('total')->readOnly()->numeric()->label('Total'),
                                ])
                                ->columns(4),
                                Section::make()
                                ->schema([
                                    Hidden::make('total_meters'),
                                    Hidden::make('total_do'),
                                    Placeholder::make('Total en metros')
                                    ->content(function ($get, Set $set) {
                                        $sum_meters = 0;
                                        foreach ($get('services') as $item) {
                                            $sum_meters += $item['meters'];
                                        }
                                        $set('total_meters', $sum_meters);
                                        return $sum_meters." mt";
                                    }),
                                    Placeholder::make('Total en pesos')
                                    ->content(function ($get, Set $set) {
                                        $sum_total = 0;
                                        foreach ($get('services') as $item) {
                                            $sum_total += $item['total'];
                                        }
                                        $set('total_do', $sum_total);
                                        return number_format($sum_total,2);
                                    })
                                ])->columns(4),
                            ])
                        ])
                ])
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('provider')->label('Proveedro')
                ->searchable(),
                TextColumn::make('date')->label('Fecha')
                ->date("d/m/Y")
                ->searchable(),
                TextColumn::make('total_meters')->label('Total en metros'),
                TextColumn::make('total_do')->money('usd')->label('Total en pesos'),
            ])
            ->filters([
                Filter::make('date')
                ->form([
                    DatePicker::make('created_from')->label("Desde"),
                    DatePicker::make('created_until')->label("Hasta"),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['created_from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                        )
                        ->when(
                            $data['created_until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                        );
                })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()->label("Eliminar"),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCierres::route('/'),
            'create' => Pages\CreateCierres::route('/create'),
            'edit' => Pages\EditCierres::route('/{record}/edit'),
        ];
    }
}