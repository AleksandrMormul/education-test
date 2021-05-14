function confirmDelete()
{
    const result = confirm('Are you sure you want to delete this ad?');
    console.log('sdfs')
    if(result){
        event.preventDefault();
        document.getElementById('delete-ad').submit();
    }
}

window.confirmDelete = confirmDelete();
