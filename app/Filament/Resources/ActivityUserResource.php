<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityUserResource\Pages;
use App\Filament\Resources\ActivityUserResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Models\Activity;
use App\Models\ActivityUser;
use App\Models\Section;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityUserResource extends Resource
{
    protected static ?string $model = ActivityUser::class;
    protected static ?string $label = "Submission";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('User Submission')->columns(2)->schema([
                    Forms\Components\Select::make('activity_id')
                        ->relationship('activity', 'name')
                        ->label('Activity')
                        ->required(),

                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->label('User')
                        ->required(),

                    Forms\Components\TextInput::make('attempts')
                        ->label('Attempts')
                        ->required()
                        ->numeric()
                        ->default(0),

                    Forms\Components\FileUpload::make('file')
                        ->label('File')
                        ->downloadable()
                        ->disabled(),

                    Forms\Components\TextInput::make('score')
                        ->label('Score')
                        ->required()
                        ->numeric(),

                    Forms\Components\TextInput::make('maxScore')
                        ->label('Max Score')
                        ->required()
                        ->numeric(),

                    Forms\Components\Toggle::make('coins_awarded')
                        ->label('Coins Awarded')
                        ->required(),
                ]),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('user.section.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('activity.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(function ($state) {
                        if ($state) {
                            return '<a href="' . \Storage::url('uploads/' . $state) . '" target="_blank" class="text-blue-600 underline">Download</a>';
                        }
                        return 'No file';
                    })
                    ->html(), // Enables HTML rendering for links
                Tables\Columns\TextColumn::make('attempts')->label("Attempt")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('score')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maxScore')
                    ->numeric()
                    ->sortable(),
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
                //
                SelectFilter::make('activity_id')
                    ->options(function () {
                        return Activity::pluck('name', 'id')->toArray(); // Assuming Section is your model name
                    })
                    ->label('Activity')
                    ->default(null)
                    ->searchable(),

                SelectFilter::make('user')->label('Section')
                    ->relationship('user.section', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityUsers::route('/'),
            'create' => Pages\CreateActivityUser::route('/create'),
            'edit' => Pages\EditActivityUser::route('/{record}/edit'),
        ];
    }
}
