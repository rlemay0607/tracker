<?php

namespace App\Filament\Resources\ActionItemResource\Pages;

use App\Filament\Resources\ActionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
class ListActionItems extends ListRecords
{
    protected static string $resource = ActionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Status'),
            'New' => Tab::make('New')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', 'New');
            }),
            'Pending' => Tab::make('Pending')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', 'Pending');
            }),
            'In Progress' => Tab::make('In Progress')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', 'In Progress');
            }),
            'Completed' => Tab::make('Completed')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', 'Completed');
            }),
            'Cancelled' => Tab::make('Cancelled')
            ->modifyQueryUsing(function ($query) {
                return $query->where('status', 'Cancelled');
            }),
        ];
    }
}
