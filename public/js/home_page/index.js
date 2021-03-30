
$('#partnersModal').on('hidden.bs.modal', function (e) {
    // $('.delete-image').click();
    $('#url').val('');
    $('#imagePreview').css('background-image' , '');
    $('#imagePreview').html('').css('height','0');
    $('label[for="p_logo"]').show()
})

$(document).on('click','.rem_pl',function () {
    $('input[type="file"]').val('');
    $('#imagePreview').css('background-image' , '');
    $('#imagePreview').html('').css('height','0');
    $('label[for="p_logo"]').show()
})
$('#p_logo').change(function () {
    readURL(this, '#imagePreview');
    $('label[for="p_logo"]').hide();
    $('#imagePreview').css('height','100px').append('<span aria-hidden="true" class="rem_pl"><i class="fa fa-close img_del"></i></span>')
})

function readURL(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $(previewId).css({'background-image' : 'url('+e.target.result +')'});
            $(previewId).hide();
            $(previewId).fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$('.block').click(function () {
    $('#partnersModal').modal('show');
    $('.save_part').one('click',function () {
        let formData = new FormData();
        let file = $('input[type=file]')[0].files[0];
        formData.append('file',file);
        formData.append('description',$('#description').val());
        formData.append('url',$('#url').val());
        formData.append('lang',$('input[name="lang"]').val());
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN':$('input[name="_token"]').val()
            }
        })
        $.ajax({
            url:'/addPartner',
            type:'POST',
            dataType: 'json',
            data:formData,
            processData: false,
            contentType: false,
            success:function(result) {
                if(result.status == 'success'){
                    let div = '<div class="partner_bl" style="float: left" data-id="'+result.id+'">\n' +
                        '<span aria-hidden="true" class="rem"><i class="fa fa-close img_del"></i></span>'+
                        '  <a href="'+$('#url').val()+'"><img src="data:image/png;base64,'+ result.image+'" width="280"\n' +
                        ' height="90" alt="ՀՀ Ազգային ժողով"></a>\n' +
                        ' </div>';
                    $('.partner').append(div);
                    $('#partnersModal').modal('hide');
                    flashMessage(result.message);
                }else{
                    flashMessage(result.message,'red');
                }
            }
        });
    })
});

$(document).on('click','.rem',function () {
    let id = $(this).parents('.partner_bl').data('id');
    $.post( '/removePartner/'+ id,{"_token": $('input[name="_token"]').val()}, function( response ) {
        if(response.status == 'success'){
            $('.partner_bl[data-id='+response.id+']').remove();
            flashMessage(response.message);
        }
    });
})

function toggleButton(e){
    $(e).find('.btn').toggleClass('active');
    if ($(e).find('.btn-primary').size()>0) {
        $(e).find('.btn').toggleClass('btn-primary');
    }
    $(e).find('.btn').toggleClass('btn-default');
    $("input[name='"+$(e).data("t")+"']").val($(e).find('.active').data('status'));
}
$(document).ready(function () {
    let tt = 't1';
    if(typeof(template) != "undefined" && template !== null){
        tt = template;
    }
    $("input[name = 'car_template']").val(tt);
    $("div.link_m[data-val="+tt+"]").find('.sd,.bd,.bd1').css('background-color', '#cdcdcd');
    $("#gallery_r").click(function () {
        $("#cat_bl").hide();
        $("#car_bl").show();
    });
    $("#news_r").click(function () {
        $("#cat_bl").show();
        $("#car_bl").hide();
    });
});
$(document).on('click', '.link_m', function () {
    let val = $(this).data('val');
    $("input[name = 'car_template']").val(val);
    $('.link_m').find('.sd,.bd,.bd1').css('background-color', '#fff');
    $(this).find('.sd,.bd,.bd1').css('background-color', '#cdcdcd');
})