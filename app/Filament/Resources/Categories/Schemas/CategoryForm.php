<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required()->label('Name'),
                TextInput::make('slug')->label('Slug')->required(),
                TextInput::make('description')->label('Description')->required(),
                ColorPicker::make('color')->label('Color')->required(),
            ]);
    }
}
