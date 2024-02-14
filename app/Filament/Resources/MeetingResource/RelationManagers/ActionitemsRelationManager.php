<?php

namespace App\Filament\Resources\MeetingResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\FileUpload;



class ActionitemsRelationManager extends RelationManager
{
    protected static string $relationship = 'actionitems';
    protected static ?string $title = 'Action Items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                ->options([
                    'New' => 'New',
                    'Pending' => 'Pending',
                    'In Progress' => 'In Progress',
                    'Completed' => 'Completed',
                    'Cancelled' => 'Cancelled',
                ])
                    ->required()
                    ->default('New'),

                Forms\Components\Select::make('contact_id')
                ->relationship('contact', 'name')
                ->label('Assigned To')
                ->required(),
                Forms\Components\DatePicker::make('due_date')
                    ->required(),
            
                
                Forms\Components\RichEditor::make('action')
                    ->required()
                    ->columnSpan(2),
                FileUpload::make('document')
                ->multiple()
                ->downloadable()
                ->openable()
                ->columnSpan(2),
            

                    
            ]);
    }



    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact.name')
                    ->numeric()
                    ->label('Assigned To')
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
               
                Tables\Columns\TextColumn::make('meeting.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('action')
                    ->html()
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                SelectFilter::make('contact_id')
                ->multiple()
                ->label('Assigned To')
                ->relationship('contact', 'name')
                ->searchable()
                ->preload(),
                SelectFilter::make('status')
                ->options([
                    'New' => 'New',
                    'Pending' => 'Pending',
                    'In Progress' => 'In Progress',
                    'Completed' => 'Completed',
                    'Cancelled' => 'Cancelled',
                ])
                ->multiple()
                ->searchable()
                ->preload(),
                Filter::make('due_date')
                    ->form([
                        DatePicker::make('due_from'),
                        DatePicker::make('due_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['due_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '>=', $date),
                            )
                            ->when(
                                $data['due_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('due_date', '<=', $date),
                            );
                    }),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-o-eye')
                    ->color('info'),
                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                     ->slideOver(),
                DeleteAction::make()
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->color('danger'),
                ])
                ->button()
                ->label('Actions')

                
            ])
            ->bulkActions([
                BulkActionGroup::make([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->delete()),
                BulkAction::make('forceDelete')
                    ->requiresConfirmation()
                    ->action(fn (Collection $records) => $records->each->forceDelete()),
            ]),
               
            ]);

    }
}
