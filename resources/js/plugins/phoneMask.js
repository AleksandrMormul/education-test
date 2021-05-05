import intlTelInput from 'intl-tel-input';

window.onload = function () {
    const input = document.getElementById('phone');
    const phoneInput = intlTelInput(input, ({
        utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/12.0.3/js/utils.js',
        allowDropdown: true
    }));
    const error = document.querySelector('.alert-error');
    error.style.display = 'none';
    input.addEventListener('change',function(){
        if (!phoneInput.isValidNumber()) {
            error.style.display = '';
            error.style.color = 'red';
            error.innerHTML = `Invalid phone number.`;
        } else {
            error.style.display = 'none';
        }
    });
}

