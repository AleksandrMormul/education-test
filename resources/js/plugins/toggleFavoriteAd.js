import config from '../../../dev.config.json';

let adIdd1;
let heartId;
let el;
window.toggleFavorite = function (id) {
    console.log(id)
    adIdd1 = id;
    heartId = `heartId-${id}`;
    //$(document).ready(function() {
    if (heartId) {
        el = document.getElementById(heartId);

            document.getElementById(heartId).addEventListener('click', function () {
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
        }
   // })
}
//$(document).on('click','.heart',function(){
//$(`#heartId${adIdd1}`).click( function () {

if (el) {
    // document.getElementById(heartId).addEventListener('click', function () {
    //     $.ajax({
    //         type: "POST",
    //         dataType: 'json',
    //         context: this,
    //         url: config.host.apiUrl + `favorites/ads/${adIdd1}/toggle`,
    //         success: function (result) {
    //             if (result['favorite'] === 'enabled') {
    //                 $(this).removeClass('far').addClass('fas');
    //             } else {
    //                 $(this).removeClass('fas').addClass('far');
    //             }
    //         },
    //         error: function (jqxhr, status, exception) {
    //             alert(exception);
    //         },
    //     });
    // })
}
