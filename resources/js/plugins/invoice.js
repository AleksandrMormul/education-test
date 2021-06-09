import getDomain from '../common/getDomain';

$(function() {
    $('#payPal').click(function(event) {
        let $target = $(event.target);
        let adId = $target.data('ad-id');
        let price = $target.data('ad-price');

        $.ajax({
            type: "POST",
            dataType: 'json',
            data: {
                'value': price,
                'ad_id': adId
            },
            url: `${getDomain()}/api/create-invoice`,
            success: function (result) {
                console.log(result)
                window.location.href = result['url'];
            },
            error: function (jqxhr, status, exception) {
                console.log(exception);
            },
        });
    })
});
