import GMaps from 'gmaps';
window.onload = function () {
    const formElement = document.getElementById("adForm");
    const formData = new FormData(formElement);
    let markers = [];

   let map = new GMaps({
        div: '#map',
        zoom: 5,
        lat: -12.043333,
        lng: -77.028333,
        click: function (e) {
            const coord = e.latLng.toJSON();
            formData.append('lat', coord.lat);
            formData.append('lng', coord.lng);
            for (const [key, value] of formData.entries()) {
                //console.log(key, value);
            }
        },
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
       console.log('//////////************************//////////////////')
        for (const [key, value] of formData.entries()) {
            //console.log(key, value);
        }
        /*var request = new XMLHttpRequest();
        request.open("POST", "/ads");
        request.send(formData);*/
        //formElement.submit();
        //formElement.onsubmit();
        //let form = $('.create-ad-from');
        //form.submit();
    });
}


