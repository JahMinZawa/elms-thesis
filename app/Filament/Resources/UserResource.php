<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityUsersResource\RelationManagers\ActivitiesRelationManager;
use App\Filament\Resources\ModuleUserResource\RelationManagers\ModulesRelationManager;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\Section;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('section_id')
                    ->relationship('section', 'name'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn($state)=> filled ($state))
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Forms\Components\TextInput::make('coins')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Select::make('roles')
                    ->preload()
                    ->relationship('roles', 'name', function (Builder $query) {
                        $query->whereNotIn('name', ['admin']);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('section.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coins')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('section_id')
                    ->options(function () {
                        return Section::pluck('name', 'id')->toArray(); // Assuming Section is your model name
                    })
                    ->label('Section')
                    ->default(null)
                    ->searchable()
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
            ModulesRelationManager::class,
            RelationManagers\LecturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Check if the authenticated user has the role 'teacher'
        if (Auth::user()->hasRole('instructor')) {
            // Filter users to only include those who have the role 'student'
            $query->whereHas('roles', function ($query) {
                $query->where('name', 'student');
            });
        }

        return $query;
    }
}
