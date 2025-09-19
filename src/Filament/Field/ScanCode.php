<?php

namespace Bites\Common\Filament\Field;

use Filament\Forms\Components\TextInput;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\Action;

class ScanCode extends TextInput
{

    protected string $view = 'bites::qr-scanner';
//     protected function setUp(): void
//     {
//         parent::setUp();
// dd($getName);
//         $this
//             ->label('Scan Code')
//             ->suffixAction(
//                 Action::make('openScanner')
//                     ->icon('heroicon-o-qr-code')
//                     ->modalHeading('Scan QR Code')
//                     ->modalContent(view('bites::qr-scanner'))
//                     ->modalSubmitAction(false) // No submit button
//             );
//     }



    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->label('Scan Code')
            ->extraAttributes([
                'icon' => 'heroicon-o-qr-code',
            ]);
    }

    // public function icon(string $icon): static
    // {
    //     return $this->extraAttributes(['icon' => $icon]);
    // }
}
