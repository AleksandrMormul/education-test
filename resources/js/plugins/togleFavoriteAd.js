import config from '../config/dev.config.json';

let adIdd1

window.toggleFavorite = function (id) {
    adIdd1 = id;
}

$(document).on('click', '.heart', function () {
    $.ajax({
        type: "POST",
        dataType: 'json',
        context: this,
        url: config.host.apiUrl + `favorites/ads/${adIdd1}/toggle`,
        success: function (result) {
            if (result['favorite'] === 'enabled') {
                $(this).removeClass('far').addClass('fas');
            } else {
                $(this).removeClass('fas').addClass('far');
            }
        },
        error: function (jqxhr, status, exception) {
            alert(exception);
        },
    });
})

