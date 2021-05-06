import GMaps from 'gmaps';
window.onload = function () {
    let markers = [];

   let map = new GMaps({
        div: '#map',
        zoom: 5,
        lat: -12.043333,
        lng: -77.028333,
    });
    map.addListener('click', function(e) {
        const coord = e.latLng.toJSON();
        if (markers.length === 0) {
            const marker = map.addMarker({
                lat: coord.lat,
                lng: coord.lng,
            });
            markers.push(marker);
        } else if(markers.length === 1) {
            markers[0].setMap(null);
            markers.shift();
            const marker = map.addMarker({
                lat: coord.lat,
                lng: coord.lng,
            });
            markers.push(marker);
        }
    });

    document.getElementById('btnSubmit').addEventListener('click',function() {
        const formElement = document.getElementById("adForm");
        const formData = new FormData(formElement);
        const request = new XMLHttpRequest();
        const coord = markers[0].getPosition();
        const inputLat = document.createElement("input");
        inputLat.type = "hidden";
        inputLat.name = "lat";
        inputLat.value = coord.lat();
        const inputLng = document.createElement("input");
        inputLng.type = "hidden";
        inputLng.name = "lng";
        inputLng.value = coord.lng();

        request.open("POST", "/ads");
        formElement.appendChild(inputLat)
        formElement.appendChild(inputLng)
        request.send(formData);
    });
}


