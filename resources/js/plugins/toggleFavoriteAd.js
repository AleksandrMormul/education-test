import getDomain from '../common/getDomain';

$(function() {
    $('.heart').click(function(event) {
        let $target = $(event.target);
        let adId = $target.data('ad-id');

        $.ajax({
            type: "POST",
            dataType: 'json',
            context: this,
            url: `${getDomain()}/api/favorites/ads/${adId}/toggle`,
            success: function (result) {
                switch (result['favorite']) {
                    case 'enabled':
                        $target.removeClass('far').addClass('fas');
                        break;
                    case 'disabled':
                    default:
                        $target.removeClass('fas').addClass('far');
                        break;
                }
            },
            error: function (jqxhr, status, exception) {
                console.log(exception);
            },
        });
    })
});
