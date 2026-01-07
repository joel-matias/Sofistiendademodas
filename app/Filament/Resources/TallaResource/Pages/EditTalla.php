<?php

namespace App\Filament\Resources\TallaResource\Pages;

use App\Filament\Resources\TallaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTalla extends EditRecord
{
    protected static string $resource = TallaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
