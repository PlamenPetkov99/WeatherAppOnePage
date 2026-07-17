// assets/controllers/mymap_controller.js
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('ux:map:marker:before-create', this._onMarkerBeforeCreate.bind(this));
        this.element.addEventListener('ux:map:marker:after-create', this._onMarkerAfterCreate.bind(this));
    }

    _onMarkerBeforeCreate(event) {
        event.detail.definition.bridgeOptions = {
            ...event.detail.definition.bridgeOptions,
            draggable: true,
        };
    }

    _onMarkerAfterCreate(event) {
        const marker = event.detail.marker;

        // marker.on('dragend', (e) => {
        //     const { lat, lng } = e.target.getLatLng();
        //     const frame = document.getElementById('the_frame_id');
        //
        //     // Setting .src on a <turbo-frame> triggers a GET request and
        //     // swaps in the matching <turbo-frame id="the_frame_id"> from the response
        //     frame.src = `${window.location.pathname}?lat=${lat}&lng=${lng}`;
        // });
        marker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng();
            document.getElementById('the_frame_id').src = `/?lat=${lat}&lng=${lng}`;
        });
    }

    // _onMarkerAfterCreate(event) {
    //     const marker = event.detail.marker; // the real L.Marker instance
    //
    //     marker.on('dragend', async (e) => {
    //         const { lat, lng } = e.target.getLatLng();
    //
    //         try {
    //             const response = await fetch(`/api/weather-at?lat=${lat}&lng=${lng}`);
    //             if (!response.ok) throw new Error(`Server returned ${response.status}`);
    //             const data = await response.json();
    //
    //             marker.setPopupContent(`<h3>${data.city}</h3><p>${data.temperature}°C</p>`);
    //             marker.openPopup();
    //         } catch (err) {
    //             console.error('Failed to fetch weather at new marker position:', err);
    //         }
    //     });
    //
    // }


}
