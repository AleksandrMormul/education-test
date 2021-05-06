import intlTelInput from 'intl-tel-input';

const input = document.getElementById('phone');
const phoneInput = intlTelInput(input, ({
    utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js',
    allowDropdown: true
}));


/*export default function validationPhoneNumber() {*/
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

