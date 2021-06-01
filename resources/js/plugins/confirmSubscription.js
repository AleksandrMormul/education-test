import getDomain from '../common/getDomain';

window.confirmSubscription = function () {
    const result = confirm('Are you sure you want to subscribe weekly sending emails?');
    if (result) {
        event.preventDefault();
        const subscribeBtn = document.getElementById('adSubscriptionBtn1');
        $.ajax({
            type: 'POST',
            dataType: 'json',
            context: this,
            url: `${getDomain()}/api/subscribe`,
            success: function (data) {
                console.log(data)
                console.log('before changes', subscribeBtn)
                switch(data.success) {
                    case 'subscribe':
                        //$('input[name=sbs]').val('Subscribe');
                        subscribeBtn.value = 'Unsubscribe';
                        subscribeBtn.classList.remove('subscriptionBtn');
                        subscribeBtn.classList.add('unSubscriptionBtn');
                        $("#deleteInfo").show();
                        //document.getElementById("deleteInfo").style.visibility = "visible";
                        //document.getElementById("subscriptionMsg").innerHTML = data.message
                       $("#subscriptionMsg").html(data.message);
                        break
                    case 'unsubscribe':
                        //$('input[name=sbs]').val('Unsubscribe');
                        subscribeBtn.value = 'Subscribe';
                        subscribeBtn.classList.remove('unSubscriptionBtn');
                        subscribeBtn.classList.add('subscriptionBtn');
                        // document.getElementById("deleteInfo").style.visibility = "visible";
                        $("#deleteInfo").show();
                        $("#subscriptionMsg").html(data.message);
                        // console.log(document.getElementById("subscriptionMsg"))

                        break;
                    default:
                        break;
                }
            },
            error: function (jqxhr, status, exception) {
                console.log(exception);
            },
        });
    }
}

