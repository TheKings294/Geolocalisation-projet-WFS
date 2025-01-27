let map
let info = L.control();
info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info');
    this.update();
    return this._div;
};
export const setMap = (x, y , zoom) => {
    map = L.map('map').setView([x, y], zoom)
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map)
}

export const setMarker = (message = null, x , y, colorValue) => {
    let color = colorValue
    let marker = L.marker([x, y], {
        icon: svgMarker(color)
    }).addTo(map)
    if(message !== null) {
        marker.bindPopup(message)
    }
    return marker
}
const svgMarker = (color) => {
    return  L.divIcon({
        html: `
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
            <path fill="${color}" 
            d="M384 192c0 87.4-117 243-168.3 307.2c-12.3 15.3-35.1 15.3-47.4 0C117 435 0 279.4 0 192C0 86 86 0 192 0S384 86 384 192z"/>
        </svg>
        `,
        iconSize: [30, 30],
        iconAnchor: [15, 15],
        className: 'custom-svg-icon'
    })
}
export const setView = (x, y, zoom) => {
    map.setView([y, x], zoom)
}
export const setPolygon = (latLang, name) => {
    info.update = function (props) {
        this._div.innerHTML = '<h4>Departement name</h4>' +  (props ?
            '<b>' + props + '</b>'
            : 'Hover over a state');
    };
    info.addTo(map);

    let polygon = L.polygon(latLang, {
        fillColor: 'bleu',
        color: 'blue',
        dashArray: '10',
    }).addTo(map)

    polygon.on({
        mouseover: function () {
            info.update(name || 'Unknown')
        },
        mouseout: function () {
            info.update()
        },
        click: zoomToFeature,
    })
}
function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}

export const hasMarker = () => {
    let hasMarker = false;

    map.eachLayer(function(layer) {
        if (layer instanceof L.Marker) {
            hasMarker = true;
        }
    });

    return hasMarker;
}
export const deletMarker = (marker) => {
    marker.remove();
}