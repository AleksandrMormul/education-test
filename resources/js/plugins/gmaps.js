import GMaps from 'gmaps';
import getNumber from './phoneMask';
window.onload = function () {
    let markers = [];
    let map;
    if(typeof isEdit !== 'undefined') {
        map = new GMaps({
            div: '#map',
            zoom: 5,
            lat: lat,
            lng: lng,
        });
        const marker = map.addMarker({
            lat: lat,
            lng: lng,
        });
        markers.push(marker);
    } else {
       map = new GMaps({
            div: '#map',
            zoom: 5,
            lat: 50.431759,
            lng: 30.517023,
        });
    }
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

    function prepareData() {
        const formElement = document.getElementById("adForm");
        const formData = new FormData(formElement);
        const request = new XMLHttpRequest();
        const coord = markers[0].getPosition();
        const fullPhoneNumber = document.createElement("input");
        fullPhoneNumber.type = "hidden";
        fullPhoneNumber.name = "fullPhoneNumber";
        fullPhoneNumber.value = getNumber();
        const inputLat = document.createElement("input");
        inputLat.type = "hidden";
        inputLat.name = "lat";
        inputLat.value = coord.lat();
        const inputLng = document.createElement("input");
        inputLng.type = "hidden";
        inputLng.name = "lng";
        inputLng.value = coord.lng();

        request.open("POST", "{!! route('ads.store') !!}");
        formElement.appendChild(inputLat)
        formElement.appendChild(fullPhoneNumber)
        formElement.appendChild(inputLng)
        request.send(formData);
    }

    if(typeof isEdit === 'undefined') {
        document.getElementById('adBtnSubmit').addEventListener('click', function () {
            prepareData();
        });
    }
    document.getElementById('adBtnSave').addEventListener('click',function() {
        prepareData();
    });
}


