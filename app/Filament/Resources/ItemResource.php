<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Inventory';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // User ID removed
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required()
                    ->native(false)
                    ->reactive()
                    ->preload(),
                Forms\Components\Select::make('sub_category_id')
                    ->relationship('subCategory', 'name', fn(Builder $query, Forms\Get $get) => $query->where('category_id', $get('category_id')))
                    ->required()
                    ->native(false)
                    ->reactive()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Select::make('condition_id')
                    ->relationship('condition', 'name')
                    ->required()
                    ->native(false)
                    ->preload(),
                Forms\Components\Select::make('size_id')
                    ->relationship('size', 'name')
                    ->native(false)
                    ->preload(),
                Forms\Components\Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->native(false)
                    ->preload(),
                Forms\Components\Select::make('color_id')
                    ->relationship('color', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('city_id')
                    ->relationship('city', 'name')
                    ->native(false)
                    ->searchable()
                    ->preload(),
                Forms\Components\Select::make('item_status_id')
                    ->relationship('itemStatus', 'name')
                    ->required()
                    ->native(false)
                    ->preload(),
                // Visibility fields removed
                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\Repeater::make('images')
                            ->relationship()
                            ->schema([
                                Forms\Components\FileUpload::make('path')
                                    ->image()
                                    ->directory('items')
                                    ->disk('public')
                                    ->required(),
                                Forms\Components\Toggle::make('is_primary'),
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->orderable('sort_order')
                            ->defaultItems(0)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\ImageColumn::make('primaryImage.path')
                    ->label('Image')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('itemStatus.name')
                    ->label('Status')
                    ->badge()
                    ->color(fn(string $state): string => match (strtolower($state)) {
                        'active' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                        'traded' => 'info',
                        'sold' => 'danger',
                        default => 'gray',
                    }),
                // Featured column removed
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
