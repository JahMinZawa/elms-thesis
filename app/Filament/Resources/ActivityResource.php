<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityResource\Pages;
use App\Filament\Resources\ActivityResource\RelationManagers;
use App\Filament\Resources\QuestionResource\RelationManagers\QuestionsRelationManager;
use App\Models\Activity;
use App\Models\Lecture;
use App\Models\Module;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('lecture_id')
                    ->relationship('lecture', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instruction')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('type')
                    ->required()
                    ->options([
                        'Quiz' => 'Quiz',
                        'Fill in the blanks' => "Fill in the blanks",
                        'FileSubmission' => "File Submission"
                    ]),
                Forms\Components\TextInput::make('time')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('attemptLimit')
                    ->required()
                    ->numeric()
                    ->default(2),
                Forms\Components\DateTimePicker::make('dateGiven')
                    ->required(),
                Forms\Components\DateTimePicker::make('deadline')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('lecture.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('time')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('attemptLimit')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dateGiven')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //

                SelectFilter::make('lecture_id')
                    ->options(function () {
                        return Lecture::pluck('name', 'id')->toArray();
                    })
                    ->label('Lecture')
                    ->default(null)
                    ->searchable()
                    ->preload(),
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
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
            'create' => Pages\CreateActivity::route('/create'),
            'edit' => Pages\EditActivity::route('/{record}/edit'),
        ];
    }
}
