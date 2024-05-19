<?php

namespace App\Filament\Resources\ActivityUserResource\Pages;

use App\Filament\Resources\ActivityUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditActivityUser extends EditRecord
{
    protected static string $resource = ActivityUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
