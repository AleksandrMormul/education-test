const config = require('path').resolve(__dirname, '../config.json')
$(function() {
    $('.orderPay').click(function(event) {
        const {PAYPAL_URL} = config;
        let $target = $(event.target);
        let invoiceOrderId = $target.data('invoice-order-id');

        window.location.href = `${PAYPAL_URL}/checkoutnow?token=${invoiceOrderId}`
    })
});
