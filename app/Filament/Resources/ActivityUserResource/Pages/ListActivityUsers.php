<?php

namespace App\Filament\Resources\ActivityUserResource\Pages;

use App\Filament\Resources\ActivityUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListActivityUsers extends ListRecords
{
    protected static string $resource = ActivityUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
