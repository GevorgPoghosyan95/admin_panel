//get person by ssn
$('#ssn_search').click(function () {
    let ssn = $('#ssn').val()
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'POST',
        url:'/ssn/check',
        data:{'ssn':ssn},
        success:function(result) {
            if(result.status == 'ok'){
                let first_name = result.data.First_Name
                let last_name = result.data.Last_Name
                let patronomic_name = result.data.Patronymic_Name
                $('input[name="first_name"]').val(first_name)
                $('input[name="last_name"]').val(last_name)
                $('input[name="father_name"]').val(patronomic_name)
            }else{
                alert(result.message)
            }
        }
    });

})
