<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarterResource\Pages;
use App\Filament\Resources\BarterResource\RelationManagers;
use App\Models\Barter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BarterResource extends Resource
{
    protected static ?string $model = Barter::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrows-right-left';

    protected static ?string $navigationGroup = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('requester_id')
                    ->relationship('requester', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('receiver_id')
                    ->relationship('receiver', 'name')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('requester_item_id')
                    ->relationship('requesterItem', 'title')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('receiver_item_id')
                    ->relationship('receiverItem', 'title')
                    ->required()
                    ->preload()
                    ->searchable(),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'accepted' => 'Accepted',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                        'disputed' => 'Disputed',
                    ])
                    ->native(false)
                    ->required()
                    ->default('pending'),
                Forms\Components\Textarea::make('rejection_reason')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('requester.name')
                    ->label('Requester')
                    ->sortable(),
                Tables\Columns\TextColumn::make('receiver.name')
                    ->label('Receiver')
                    ->sortable(),
                Tables\Columns\TextColumn::make('requesterItem.title')
                    ->label('Requester Item'),
                Tables\Columns\TextColumn::make('receiverItem.title')
                    ->label('Receiver Item'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending' => 'warning',
                        'accepted' => 'success',
                        'rejected' => 'danger',
                        'cancelled' => 'gray',
                        'completed' => 'success',
                        'disputed' => 'danger',
                        default => 'gray',
                    }),
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
                // Tables\Actions\CreateAction::make(),
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
            'index' => Pages\ListBarters::route('/'),
            'create' => Pages\CreateBarter::route('/create'),
            'edit' => Pages\EditBarter::route('/{record}/edit'),
        ];
    }
}
