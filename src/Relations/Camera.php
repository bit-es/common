<?php

namespace Bites\Common\Relations;

use Bites\Common\Filament\Resources\SnapShots\Pages;
use Filament\Actions;
use Filament\Forms\Components;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns;
use Filament\Tables\Table;

class Camera extends RelationManager
{
    protected static string $relationship = 'camera';

    protected static ?string $title = 'SnapShots';

    public ?array $withValues = null;

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Components\TextInput::make('title')->required(),
            Components\TextInput::make('photo_tag')->required(),
            Components\FileUpload::make('value')->disk('public'),
            Components\TextInput::make('criteria'),
            Components\TextInput::make('parent_id')->numeric(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Columns\Layout\Split::make([
                    Columns\ImageColumn::make('value')
                        ->imageHeight(150)
                        ->disk('public')
                        ->label('Snapshot Image'),
                    Columns\Layout\Stack::make([
                        Columns\TextColumn::make('title')->color('primary'),
                        Columns\TextColumn::make('photo_tag')->icon('bites-comment-01'),
                        Columns\TextColumn::make('creator.name')->icon('bites-image-add-02'),
                    ]),
                ]),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 3,
            ])
            ->headerActions([
                Actions\CreateAction::make('snapshot')
                    ->label('Add')
                    ->icon('heroicon-o-camera')
                    ->action(function () {
                        $url = \Bites\Common\CommonPlugin::getCreateSnapshotRouteFromPage([
                            'modelId' => $this->ownerRecord->id,
                            'modelType' => get_class($this->ownerRecord),
                            'returnTo' => request()->session()->previousUrl(),
                            'photo_tag' => $this->withValues['photo_tag'] ?? null,
                            'title' => $this->withValues['title'] ?? null,
                            'filepath' => $this->withValues['filepath'] ?? null,
                        ]);

                        return redirect($url);
                    }),
                // ->visible(fn () => $this->withValues['snapshot'] ?? false),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'create' => Pages\CreateSnapshot::route('/create'),
            'qrscan' => Pages\QrScanner::route('/qrscan'),
        ];
    }
    
}
