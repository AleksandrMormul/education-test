import config from '../../../config.json';
$(function() {
    $('.orderPay').click(function(event) {
        let $target = $(event.target);
        let invoiceOrderId = $target.data('invoice-order-id');

        window.location.href = `${config.PAYPAL_URL}/checkoutnow?token=${invoiceOrderId}`
    })
});
