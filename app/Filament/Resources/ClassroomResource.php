<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClassroomResource\Pages;
use App\Filament\Resources\ClassroomResource\RelationManagers;
use App\Models\Classroom;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Card;
use Filament\Forms\Set;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Str;

class ClassroomResource extends Resource
{
    protected static ?string $model = Classroom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')->label('Nama Kelas')->required()->live(onBlur: true)->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                        TextInput::make('slug')->label('Slug')->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Nama Kelas'),
                TextColumn::make('slug')->label('Slug'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClassrooms::route('/'),
        ];
    }

    public static function getLabel(): ?string
    {
        $locale = app()->getLocale();

        if ($locale === 'id') {
            return 'Kelas';
        } else {
            return 'Classroom';
        }
    }
}
