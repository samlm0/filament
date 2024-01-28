<?php

namespace App\Filament\Resources\DemoResource\Pages;

use App\Filament\Resources\DemoResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;

class CreateDemo extends CreateRecord
{
    protected static string $resource = DemoResource::class;

    public function form(Form $form): Form
    {
        $schemas = [
            Forms\Components\Fieldset::make()->schema([
                Forms\Components\Select::make('a')
                    ->required()
                    ->label("Test")
                    ->options(['ok', 'not ok' => 'not ok', 'ok'])
                    ->live(),
                Forms\Components\Select::make('b')
                    ->label("Working select with `multiple`")
                    ->options(['a', 'b', 'c'])
                    ->required()
                    ->multiple(),
            ]),

            Forms\Components\Fieldset::make()
                ->hidden(function (Get $get) {
                    $v = $get('a');
                    return $v != 'not ok';
                })
                ->schema(function (Get $get) {
                    $v = $get('a');
                    if ($v != 'not ok') return [];

                    /**
                     * query database to dynamic create component on the fly
                     */

                    return [
                        Forms\Components\CheckboxList::make('options.1')
                            ->required()
                            ->label("Buggy checkboxlist")
                            ->bulkToggleable()
                            ->options(['a' => 'a', 'b' => 'b', 'c' => 'c']),
                        Forms\Components\Select::make('options.2')
                            ->required()
                            ->label("Working select without `multiple`")
                            ->options(['a' => 'a', 'b' => 'b', 'c' => 'c']),

                        Forms\Components\Select::make('options.3')
                            ->required()
                            ->multiple()
                            ->label("Buggy select with `multiple` (missing after submit)")
                            ->options(['a' => 'a', 'b' => 'b', 'c' => 'c']),
                    ];
                })
        ];
        return $form->columns(1)->schema($schemas);
    }
}
