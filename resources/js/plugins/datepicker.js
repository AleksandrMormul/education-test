import datepicker from 'js-datepicker';

datepicker('#adEndDate', {
    minDate: new Date(),
    formatter: (input, date, instance) => {
        let currentMonth = date.getMonth() + 1;
        if (currentMonth < 10) {
            currentMonth = '0' + currentMonth;
        }
        input.value = date.getDate()  + "-" + currentMonth + "-" + date.getFullYear()
    },
});