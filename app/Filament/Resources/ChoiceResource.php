<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChoiceResource\Pages;
use App\Filament\Resources\ChoiceResource\RelationManagers;
use App\Models\Choice;
use App\Models\Question;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Request;

class ChoiceResource extends Resource
{
    protected static ?string $model = Choice::class;
    protected static ?string $slug = 'choices/';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('question_id')
                    ->relationship('question', 'question')
                    ->searchable()
                    ->required(),
                Forms\Components\Textarea::make('choice')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_correct')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {

        if(request()->route('record')) {
            $question = Question::find(request()->route('record'));
            $activity = $question->activity;


            if ($activity->type == "Fill in the blanks") {
                return $table
                    ->columns([
                        Tables\Columns\TextColumn::make('choice')
                            ->numeric()
                            ->sortable(),
                        Tables\Columns\IconColumn::make('is_correct')
                            ->boolean(),
                    ])
                    ->filters([
                        //
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
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question')
                    ->sortable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('choice')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_correct')
                    ->boolean(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListChoices::route('/'),
            'create' => Pages\CreateChoice::route('/create'),
            'choices' => Pages\ListChoices::route('/{record}'),
            'edit' => Pages\EditChoice::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Check if the request is for the 'edit' page
        if (Request::is('*/*/edit')) {
            return $query;
        }

        // Check if there is an ID in the URL
        if (request()->route('record')) {
            // Apply the lesson ID filter
            $query->where('question_id', request()->route('record'));
        }

        return $query;
    }
}
