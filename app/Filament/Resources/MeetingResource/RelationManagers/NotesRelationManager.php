<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class NotesRelationManager extends RelationManager
{
    protected static string $relationship = 'notes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                  Forms\Components\TextInput::make('subject')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(2),
                 Forms\Components\RichEditor::make('note')
                    ->columnSpan(2)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('note')
            ->columns([
                Tables\Columns\TextColumn::make('note'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
