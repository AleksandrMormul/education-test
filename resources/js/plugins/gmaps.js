import GMaps from 'gmaps';
window.onload = function () {
    const formElement = document.getElementById("adForm");
    const formData = new FormData(formElement);

    new GMaps({
        div: '#map',
        zoom: 5,
        lat: -12.043333,
        lng: -77.028333,
        click: function (e) {
            const coord = e.latLng.toJSON();
            formData.append('lat', coord.lat);
            formData.append('lng', coord.lng);
            for (const [key, value] of formData.entries()) {
                console.log(key, value);
            }
        },
    });

    document.getElementById('btnSubmit').addEventListener('click',function() {
       console.log('//////////************************//////////////////')
        for (const [key, value] of formData.entries()) {
            console.log(key, value);
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


