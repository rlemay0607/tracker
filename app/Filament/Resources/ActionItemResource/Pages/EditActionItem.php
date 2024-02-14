<?php

namespace App\Filament\Resources\ActionItemResource\Pages;

use App\Filament\Resources\ActionItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActionItem extends EditRecord
{
    protected static string $resource = ActionItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
