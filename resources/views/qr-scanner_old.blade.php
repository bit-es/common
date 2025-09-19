<div
    x-data="{
        html5QrcodeScanner: null,
        stopScanning() {
            if (!this.html5QrcodeScanner) return;
            this.html5QrcodeScanner.pause();
            this.html5QrcodeScanner.clear();
            this.html5QrcodeScanner = null;
        },
        openScannerModal() {
            $dispatch('open-modal', { id: 'qr-scanner-modal-{{ $getName() }}' });
            this.startCamera();
        },
        closeScannerModal() {
            this.stopScanning();
            $dispatch('close-modal', { id: 'qr-scanner-modal-{{ $getName() }}' });
        },
        onScanSuccess(decodedText) {
            $wire.set('{{ $getStatePath() }}', decodedText);
            this.closeScannerModal();
        },
        startCamera() {
            this.html5QrcodeScanner = new Html5QrcodeScanner(
                'reader-{{ $getName() }}',
                { fps: 10, qrbox: { width: 250, height: 250 } },
                false
            );
            this.html5QrcodeScanner.render(this.onScanSuccess.bind(this));
        }
    }"
    x-init="$nextTick(() => { if ($el.querySelector('[data-scan-trigger]')) $el.querySelector('[data-scan-trigger]').addEventListener('click', openScannerModal) })"
    x-load-js="['https://unpkg.com/html5-qrcode']"
>
        <x-filament::input.wrapper>
            <x-filament::input
                type="text"
                name="{{ $getName() }}"
                id="{{ $getId() }}"
                value="{{ $getState() }}"
                placeholder="{{ $getPlaceholder() }}"
                class="w-full pr-10"
            />

            <x-slot name="suffix">
                <button
                    type="button"
                    data-scan-trigger
                    class="flex items-center pr-3 text-gray-400 hover:text-primary-500 focus:outline-none"
                    aria-label="Scan QR Code"
                >
                    <x-filament::icon
                        :name="$getExtraAttributes()['heroicon'] ?? 'heroicon-o-qr-code'"
                        class="w-5 h-5"
                    />
                    <span class="ml-1 text-sm">Scan</span>
                </button>
            </x-slot>
        </x-filament::input.wrapper>

    <x-filament::modal
        id="qr-scanner-modal-{{ $getName() }}"
        width="lg"
        :close-by-escaping="false"
        :close-button="false"
        :close-by-clicking-away="false"
    >
        <x-slot name="header">
            <h2 class="text-lg font-semibold">
                Scan code for {{ $getLabel() ?? 'QR Code' }}
            </h2>
        </x-slot>

        <div class="p-4">
            <div id="reader-{{ $getName() }}" class="w-full h-[300px]"></div>
        </div>

        <x-slot name="footer">
            <x-filament::button @click="closeScannerModal()" color="danger">
                Cancel
            </x-filament::button>
        </x-slot>
    </x-filament::modal>
</div>
