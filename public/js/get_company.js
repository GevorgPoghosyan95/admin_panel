//get company by taxid
$('#taxid_search').click(function () {
    let taxid = $('#taxid').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:'/taxid/check',
        data:{'taxid':taxid},
        success:function(result) {
            if(result.status == 'OK'){
                let fullName  = result.data.company_name
                $('input[name="fullName"]').val(fullName)
            }else{
                alert(result.error.message)
            }
        }
    });

})
