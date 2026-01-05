<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Content')
                    ->description('Main content of the post')
                    ->collapsible()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        TextInput::make('slug')
                            ->required(),
                        RichEditor::make('content')
                            ->required(),
                    ])->columnSpan(2),
                Section::make('Details')
                    ->collapsible()
                    ->schema([
                        Group::make([
                            Select::make('category_id')
                                ->label('Category')
                                ->relationship('category', 'name')
                                ->required(),
                            FileUpload::make('thumbnail')
                                ->label('Thumbnail Image')
                                ->image()
                                ->disk('public')
                                ->directory('thumbnails')
                                ->nullable(),
                            TagsInput::make('tags')
                                ->suggestions(['tailwind', 'laravel', 'filament', 'php', 'javascript']),
                            Toggle::make('published')->required(),
                        ]),
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
