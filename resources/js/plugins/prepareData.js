import getNumber from "./phoneMask";

export default function prepareData(markers) {
    const formElement = document.getElementById("adForm");
    const formData = new FormData(formElement);
    const request = new XMLHttpRequest();
    const coord = markers[0].getPosition();
    const fullPhoneNumber = document.createElement("input");
    fullPhoneNumber.type = "hidden";
    fullPhoneNumber.name = "phone_number";
    fullPhoneNumber.value = getNumber();
    const inputLat = document.createElement("input");
    inputLat.type = "hidden";
    inputLat.name = "latitude";
    inputLat.value = coord.lat();
    const inputLng = document.createElement("input");
    inputLng.type = "hidden";
    inputLng.name = "longitude";
    inputLng.value = coord.lng();

    request.open("POST", "http://localhost/ads");
    formElement.appendChild(inputLat)
    formElement.appendChild(fullPhoneNumber)
    formElement.appendChild(inputLng)
    request.send(formData);
}
