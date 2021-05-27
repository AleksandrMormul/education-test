window.confirmSubscription = function ()
{
    const result = confirm('Are you sure you want to subscribe weekly sending emails?');
    if(result){
        event.preventDefault();
        document.getElementById('adSubscription').submit();
    }
}
