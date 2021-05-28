import GMaps from 'gmaps';
import prepareData  from './prepareData';

const form = document.getElementById('adForm');

if (form) {
    let markers = [];
    let map;
    if (typeof isEdit !== 'undefined' && lat && lng) {
        map = new GMaps({
            div: '#adMap',
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
            div: '#adMap',
            zoom: 5,
            lat: 50.431759,
            lng: 30.517023,
        });
    }
    map.addListener('click', function (e) {
        const coord = e.latLng.toJSON();
        if (markers.length === 0) {
            const marker = map.addMarker({
                lat: coord.lat,
                lng: coord.lng,
            });
            markers.push(marker);
        } else if (markers.length === 1) {
            markers[0].setMap(null);
            markers.shift();
            const marker = map.addMarker({
                lat: coord.lat,
                lng: coord.lng,
            });
            markers.push(marker);
        }
    });
}
$(document).ready(function() {
    $("#adBtnSubmit").click(function(){
        prepareData(markers);
    });
    $("#adBtnSave").click(function(){
        prepareData(markers);
    });
});



