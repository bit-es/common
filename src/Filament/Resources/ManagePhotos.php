<?php

namespace Bites\Common\Filament\Resources;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Forms;
use Filament\Tables;

class ManagePhotos extends RelationManager
{
    protected static string $relationship = 'photos';

    public function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('url')->required()->url(),
        ]);
    }

    public function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('url')->label('Image URL'),
            Tables\Columns\TextColumn::make('created_at')->dateTime(),
        ]);
    }
}
