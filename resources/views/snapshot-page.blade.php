<x-filament::page>
    <div>
        <div id="map" style="width: 100%; height: 150px;"></div> <!-- Map canvas -->
        <p id="location"></p> <!-- Display location here -->
        <video id="video" style="width: 100%; height: auto;"></video>



        <x-filament::button id="snapshotButton" icon="heroicon-o-camera">
            Snap
        </x-filament::button>

        <x-filament::button id="switchCameraButton" icon="bites-swap-cam">
        </x-filament::button>
    </div>

    <!-- Include Leaflet CSS and JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const video = document.getElementById('video');
            const snapshotButton = document.getElementById('snapshotButton');
            const switchCameraButton = document.getElementById('switchCameraButton');
            const loadingIndicator = document.getElementById('loading');
            const locationElement = document.getElementById('location');
            let currentStream = null;
            let useFrontCamera = true;
            let latitude = null;
            let longitude = null;

            const startCamera = () => {
                if (currentStream) {
                    currentStream.getTracks().forEach(track => track.stop());
                }

                const constraints = {
                    video: {
                        facingMode: useFrontCamera ? 'user' : 'environment'
                    },
                    audio: false
                };

                navigator.mediaDevices.getUserMedia(constraints)
                    .then((stream) => {
                        currentStream = stream;
                        video.srcObject = stream;
                        video.play();
                    })
                    .catch((error) => {
                        console.error("Camera access denied:", error);
                    });
            };

            const getLocation = () => {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((position) => {
                        latitude = position.coords.latitude;
                        longitude = position.coords.longitude;
                        locationElement.textContent = `Latitude: ${latitude}, Longitude: ${longitude}`;
                        initializeMap(latitude, longitude);
                    }, (error) => {
                        console.error("Geolocation error:", error);
                    });
                } else {
                    console.error("Geolocation is not supported by this browser.");
                }
            };

            const initializeMap = (lat, lon) => {
                const map = L.map('map').setView([lat, lon], 16);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup('You are here.')
                    .openPopup();
            };

            startCamera();
            getLocation();

            switchCameraButton.addEventListener('click', () => {
                useFrontCamera = !useFrontCamera;
                startCamera();
            });

            snapshotButton.addEventListener('click', () => {

                const canvas = document.createElement('canvas');
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const context = canvas.getContext('2d');
                context.drawImage(video, 0, 0, canvas.width, canvas.height);
                const dataUrl = canvas.toDataURL('image/png');

                // Retrieve modelId and modelType from URL
                const urlParams = new URLSearchParams(window.location.search);
                const modelId = urlParams.get('modelId');
                const modelType = urlParams.get('modelType');
                const done_route = urlParams.get('returnTo');
                const photo_tag = urlParams.get('photo_tag');
                const filepath = urlParams.get('filepath');
                const title = urlParams.get('title');

                // Send the snapshot and parameters to the server using Livewire
                @this.call('saveSnapshot', dataUrl, modelId, modelType, done_route, photo_tag, title, latitude,
                        longitude,filepath)
                    .then(response => {
                        console.log('Snapshot saved:', response);
                    })
                    .catch(error => {
                        console.error('Error saving snapshot:', error);
                    });
            });
        });
    </script>
</x-filament::page>
