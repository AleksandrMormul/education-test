import getNumber from "./phoneMask";
import getDomain from '../common/getDomain';

export default function prepareData(markers) {
    const formElement = document.getElementById("adForm");
    const formData = new FormData(formElement);
    const request = new XMLHttpRequest();

    if (markers.length > 0) {
        const coord = markers[0].getPosition();
        const inputLat = document.createElement("input");
        inputLat.type = "hidden";
        inputLat.name = "latitude";
        inputLat.value = coord.lat();

        const inputLng = document.createElement("input");
        inputLng.type = "hidden";
        inputLng.name = "longitude";
        inputLng.value = coord.lng();

        formElement.appendChild(inputLat);
        formElement.appendChild(inputLng);
    }

    const fullPhoneNumber = document.createElement("input");
    fullPhoneNumber.type = "hidden";
    fullPhoneNumber.name = "phone_number";
    fullPhoneNumber.value = getNumber();

    const price = document.getElementById('adPrice').value;
    const penny = document.createElement('input');
    penny.type = "hidden";
    penny.name = 'price';
    penny.value = parseFloat(price) * 100;

    request.open("POST", `${getDomain()}/ads`);


    formElement.appendChild(fullPhoneNumber);
    formElement.appendChild(penny);

    request.send(formData);
}
