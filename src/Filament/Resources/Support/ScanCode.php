<?php

namespace Bites\Common\Filament\Resources\Support;

use Filament\Forms\Components\TextInput;

class ScanCode extends TextInput
{
    protected string $view = 'bites::qr-scanner';

    protected function setUp(): void
    {
        parent::setUp();

        $this->placeholder('Enter '.strtolower($this->getLabel()).'...');
        $this->extraAttributes(['heroicon' => 'heroicon-o-camera']);
    }

    public function icon(string $icon): static
    {
        return $this->extraAttributes(['icon' => $icon]);
    }
}
