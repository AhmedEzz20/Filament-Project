<?php

namespace App\Filament\Resources\Posts\RelationManagers;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $relatedResource = UserResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('email')->searchable(),
                Tables\Columns\TextColumn::make('pivot.order')
                    ->label('Order')
                    ->sortable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->recordSelectSearchColumns(['name', 'email'])
                    ->mutateFormDataUsing(fn($data) => [
                        'order' => DB::table('user_post')->max('order') + 1,
                    ]),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit Order')
                    ->form([
                        TextInput::make('pivot.order')
                            ->label('Order')
                            ->numeric()
                            ->required(),
                    ])
                    ->using(function ($record, array $data) {
                        // Update ONLY pivot data
                        $record->pivot->update([
                            'order' => $data['pivot']['order'],
                        ]);

                        return $record;
                    }),

                DetachAction::make(),
            ]);
    }
}
