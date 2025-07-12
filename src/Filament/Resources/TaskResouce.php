<?php

namespace Bites\Common\Filament\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Bites\Common\Models\Task;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;
 
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document';
    protected static ?string $navigationGroup = 'Bites Common';
 
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->required(),
            Forms\Components\Textarea::make('description')->nullable(),
            Forms\Components\TextInput::make('taskable_type')->disabled(),
            Forms\Components\TextInput::make('taskable_id')->disabled(),
        ]);
    }
 
    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('title'),
            Tables\Columns\TextColumn::make('taskable_type'),
            Tables\Columns\TextColumn::make('taskable_id'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ])
        ->filters([])
        ->actions([
            Tables\Actions\EditAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\DeleteBulkAction::make(),
        ]);
    }
 
    public static function getPages(): array
    {
        return [
            'index' => \Filament\Resources\Pages\ListRecords::route('/'),
            'create' => \Filament\Resources\Pages\CreateRecord::route('/create'),
            'edit' => \Filament\Resources\Pages\EditRecord::route('/{record}/edit'),
        ];
    }
}