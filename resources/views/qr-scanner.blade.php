<div xmlns:x-filament="http://www.w3.org/1999/html" x-load-js="['https://unpkg.com/html5-qrcode']" x-data="{
    html5QrcodeScanner: null,
    stopScanning() {
        if (!this.html5QrcodeScanner) {
            return;
        }
        this.html5QrcodeScanner.pause();
        this.html5QrcodeScanner.clear();
        this.html5QrcodeScanner = null;
    },
    openScannerModal() {
        $dispatch('open-modal', { id: 'qrcode-scanner-modal-{{ $getName() }}' });
        this.startCamera();
    },
    closeScannerModal() {
        this.stopScanning();
        $dispatch('close-modal', { id: 'qrcode-scanner-modal-{{ $getName() }}' });
    },
    onScanSuccess(decodedText, decodedResult) {
        $wire.set('{{ $getStatePath() }}', decodedText);
        $dispatch('close-modal', { id: 'qrcode-scanner-modal-{{ $getName() }}' });
        this.stopScanning();
    },
    startCamera() {
        this.html5QrcodeScanner = new Html5QrcodeScanner('reader-{{ $getName() }}', { fps: 10, qrbox: { width: 250, height: 250 } }, false);
        this.html5QrcodeScanner.render(this.onScanSuccess.bind(this));
    }
}">
    <div class="grid gap-y-2">
        <div class="flex items-center gap-x-3 justify-between">
            <label for="{{ $getId() }}" class="fi-fo-field-wrp-label inline-flex items-center gap-x-3">
                <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                    {{ $getLabel() ?? 'Input Label' }}
                    @if ($isRequired())
                        <sup class="text-danger-600 dark:text-danger-400 font-medium">*</sup>
                    @endif
                </span>
            </label>
        </div>

        <x-filament::input.wrapper>
            <x-filament::input type="text" name="{{ $getName() }}" id="{{ $getId() }}"
                value="{{ $getState() }}" placeholder="{{ $getPlaceholder() }}" class="w-full pr-10" />

            <x-slot name="suffix">
                <!-- Trigger Button for Filament Modal -->
                <button type="button" @click="openScannerModal()" class="flex items-center pr-3 focus:outline-none">
                    <x-filament::icon :name="$getExtraAttributes()['icon'] ?? 'heroicon-o-qr-code'" class="w-5 h-5" />
                    <span class="ml-1 text-sm">Scan</span>
                </button>
            </x-slot>
        </x-filament::input.wrapper>

    </div>

    <!-- Filament Modal for QrCode Scanner -->
    <x-filament::modal id="qrcode-scanner-modal-{{ $getName() }}" width="lg" :close-by-escaping="false" :close-button="false"
        :close-by-clicking-away="false">
        <x-slot name="header">
            <h2 class="text-lg font-semibold">
                Scan code for {{ $getLabel() ?? 'QrCode' }}
            </h2>
        </x-slot>

        <div class="p-4">
            <div id="scanner-container">
                <div id="reader-{{ $getName() }}" width="600px" height="600px"></div>
            </div>
        </div>

        <x-slot name="footer">
            <x-filament::button @click="closeScannerModal()" color="danger">
                Cancel
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</div>
