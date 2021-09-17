import getDomain from '../common/getDomain';
import * as config from './../../../config.json'

$(function() {
    $('.btnApprove').click(function(event) {
        let $target = $(event.target);
        let invoiceOrderId = $target.data('invoice-order-id');
        let invoiceId = $target.data('invoice-id');
        const {PAYPAL_CLIENT_ID} = config;
        const {PAYPAL_CLIENT_SECRET} = config;
        const credentials = `${PAYPAL_CLIENT_ID}:${PAYPAL_CLIENT_SECRET}`;
        let buff = new Buffer(credentials);
        const basicAuth = buff.toString('base64');

        $.ajax({
            type: "POST",
            dataType: 'json',
            headers: {
                'Authorization':`Basic ${ basicAuth }`,
                'Content-Type':'application/json'
            },
            url: `${config.PAYPAL_API_URL}/v2/checkout/orders/${invoiceOrderId}/capture`,
            success: function (result) {
                console.log(result)
                let approveBtn = document.getElementById("payPalConfirm");
                approveBtn.remove();

                const tag = document.createElement("p");
                const text = document.createTextNode(result['status']);
                tag.appendChild(text);
                const element = document.getElementById(`handle-${invoiceId}`);
                element.appendChild(tag);

                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    data: {
                        'resource' : result
                    },
                    url: `${getDomain()}/api/webhook`,
                    success: function (result) {
                        console.log(result)
                    },error: function (jqxhr, status, exception) {
                        console.log(exception);
                    },
                });
            },
            error: function (jqxhr, status, exception) {
                console.log(exception);
            },
        });
    })
});
