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

        marker.on('dragend', (e) => {
            const { lat, lng } = e.target.getLatLng();
            document.getElementById('the_frame_id').src = `/?lat=${lat}&lng=${lng}`;
        });
    }
}
