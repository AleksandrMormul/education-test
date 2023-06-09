import datepicker from 'js-datepicker';

const form = document.getElementById('adForm');
if (form) {
    datepicker('#adEndDate', {
        minDate: (typeof endDate !== 'undefined') ? endDate : new Date(),
        formatter: (input, date, instance) => {
            let currentMonth = date.getMonth() + 1;
            if (currentMonth < 10) {
                currentMonth = '0' + currentMonth;
            }
            input.value = date.getDate() + "-" + currentMonth + "-" + date.getFullYear()
        },
    });
}
