<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserWantResource\Pages;
use App\Models\UserWant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UserWantResource extends Resource
{
    protected static ?string $model = UserWant::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?string $navigationGroup = 'User Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->preload(),
                Forms\Components\Select::make('sub_category_id')
                    ->relationship('subCategory', 'name', fn(Builder $query, Forms\Get $get) => $query->where('category_id', $get('category_id')))
                    ->searchable()
                    ->preload(),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Select::make('condition')
                    ->options([
                        'new' => 'New',
                        'like_new' => 'Like New',
                        'used' => 'Used',
                        'damaged' => 'Damaged',
                    ]),
                Forms\Components\TextInput::make('size'),
                Forms\Components\TextInput::make('brand'),
                Forms\Components\TextInput::make('color'),
                Forms\Components\FileUpload::make('images')
                    ->multiple()
                    ->image()
                    ->directory('user-wants')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('keywords')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subCategory.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('brand')
                    ->searchable(),
                Tables\Columns\TextColumn::make('condition')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListUserWants::route('/'),
            'create' => Pages\CreateUserWant::route('/create'),
            'edit' => Pages\EditUserWant::route('/{record}/edit'),
        ];
    }
}
