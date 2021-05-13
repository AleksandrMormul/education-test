import intlTelInput from 'intl-tel-input';

    const input = document.getElementById('phone');
    const phoneInput = intlTelInput(input, ({
        formatOnDisplay: true,
        hiddenInput: "full_number",
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js',
    }));

    if(typeof isEdit !== 'undefined') {
        phoneInput.setNumber(phoneNumber);
    }
    const errorMap = ['Invalid number', 'Invalid country code', 'Too short', 'Too long', 'Invalid number'];
    const error = document.querySelector('.phone-error');
    error.style.display = 'none';
    input.addEventListener('change', function () {

    if (phoneInput.isValidNumber()) {
        error.style.display = 'none';
    } else {
        const errorCode = phoneInput.getValidationError();
        error.style.display = '';
        error.style.color = 'red';
        error.innerHTML = errorMap[errorCode];
    }
});

export default function getNumber() {
    return phoneInput.getNumber().toString();
}
