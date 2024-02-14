<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActionItemResource\Pages;
use App\Filament\Resources\ActionItemResource\RelationManagers;
use App\Models\ActionItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filement\Tables\Columns\TextColumn;
use filament\Tables\Columns\SelectColumn;
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






class ActionItemResource extends Resource
{
    protected static ?string $model = ActionItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    protected static ?string $recordTitleAttribute = 'title';



    public static function form(Form $form): Form
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
                
                
                Forms\Components\Select::make('meeting_id')
                    ->relationship('meeting', 'name')
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

    public static function table(Table $table): Table
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

    public static function getRelations(): array
    {
        return [
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActionItems::route('/'),
            'create' => Pages\CreateActionItem::route('/create'),
            
        ];
    }
    
}
