<?php

namespace Bites\Common\Filament\Resources\MeasurementConfigs\Pages;

use Bites\Common\Filament\Resources\MeasurementConfigs\MeasurementConfigResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListMeasurementConfigs extends ListRecords
{
    protected static string $resource = MeasurementConfigResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $fields = $this->getModel()::query()
            ->select('for_model')
            ->distinct()
            ->pluck('for_model')
            ->filter()
            ->values();

        $tabs = [
            'all' => Tab::make('All'),
        ];

        foreach ($fields as $field) {
            $tabs[$field] = Tab::make(ucfirst($field))
                ->modifyQueryUsing(fn (Builder $query) => $query->where('for_model', $field));
        }

        return $tabs;
    }
}
