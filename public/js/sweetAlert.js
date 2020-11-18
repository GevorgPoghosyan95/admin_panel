var confirmed = false;
$('input[value="Delete"]').click(function(e){
    let button = $(this);
    if (!confirmed) {
        e.preventDefault()
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                confirmed = true
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
                setTimeout(function(){
                    button.click()
                },1000)
            }
        })
    }
})
