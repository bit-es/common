<?php

namespace Bites\Common\Filament\Resources;

use App\Filament\Resources\SnapshotResource\Pages\CreateSnapshot;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ManageSnapshot extends RelationManager
{
    protected static string $relationship = 'snapshots';

    public ?array $description = null;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('snapshotable_type')
                    ->required(),
                Forms\Components\TextInput::make('snapshotable_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('title')
                    ->required(),
                Forms\Components\TextInput::make('key')
                    ->required(),
                Forms\Components\FileUpload::make('value')
                    ->disk('public'),
                Forms\Components\TextInput::make('criteria'),
                Forms\Components\TextInput::make('parent_id')
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    ImageColumn::make('value')
                        ->height(150)
                        ->disk('public')
                        ->label('Snapshot Image'),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('title')->color('primary'),
                        Tables\Columns\TextColumn::make('key')->icon('hugeicons-comment-01'),
                        Tables\Columns\TextColumn::make('creator.name')->icon('hugeicons-image-add-02'),
                    ]),

                ]),

            ])->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->headerActions([
                Tables\Actions\Action::make('Add')
                    ->icon('heroicon-o-camera')
                    ->action(function () {
                        // Pass the record data to the CreateSnapshot page
                        return redirect()->route('filament.sysadmin.resources.snapshots.create', [
                            'modelId' => $this->ownerRecord->id,
                            'modelType' => get_class($this->ownerRecord),
                            'returnTo' => request()->session()->previousUrl(),
                            'key' => $this->description['key'] ?? null,
                            'title' => $this->description['title'] ?? null,
                        ]);
                    }),
            ])
            ->actions([]);
    }

    public static function getPages(): array
    {
        return [
            'create' => CreateSnapshot::route('/create'),
        ];
    }
}
