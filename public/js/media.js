// upload picture
/*$('#med_pic').on('input',function () {
    let fd = new FormData(),
        file = $(this)[0].files,
        _self =$(this)[0],
        fol = $('#fldr').val();
    fd.append('file',file[0]);
    fd.append('folder',fol);
    ajaxCsrf();
    $.ajax({
        url: 'media/upload',
        type: 'post',
        data: fd,
        contentType: false,
        processData: false,
        success: function(response){
            // console.log(response);
            if(response.status == 'success'){
                let div = '<div class="img_box" data-id="'+response.id +'">' +
                    '<span aria-hidden="true" class="rem">' +
                    '<i class="fa fa-close img_del"></i></span>' +
                    '<p class="vert">' + readableBytes(response.size) +'</p>'+
                    '<img class="blah" src="'+response.path +'" />' +
                    '<a href="javascript:void(0) " style="margin-top: 1px" data-path="' + response.public_url + '">copy public path</a>' +
                    '</div>';
                if(fol == '0'){
                    $('.img_bl').append(div);
                } else{
                    $('.f_box[data-id='+fol+']').find('.count').text(response.cnt);
                    $('.f_data').append(div);
                }
                flashMessage(response.message)
                // alert("ok");
                // readURL(_self)
            }else{
                // $.each(response.error.file,function (i,v) {
                    // console.log(v);
                    flashMessage(response.error.file,'red')
                // })
            }
        },
        error: function (xhr) {
            console.log((xhr));
        }
    });
});*/

// function readURL(input) {
//     if (input.files && input.files[0]) {
//         let reader = new FileReader(),
//             img_bl = null;
//         reader.onload = function(e) {
//             img_bl = $("<div class='img_box'><img class='blah' src="+e.target.result+" /></div>")
//             console.log(img_bl);
//             $('.img_bl').append(img_bl[0])
//         }
//         reader.readAsDataURL(input.files[0]); // convert to base64 string
//     }
// }

let $modal = $('#modal');
let image = document.getElementById('image');
let cropper;
let send_data= [];
$(document).on('click', '.blah', function (e) {
    let url = $(this).attr('src');
    $modal.modal('show');
    image.src = url;
    let fname = url.replace(/^.*[\\\/]/, ''),
    id = $(this).parent().data('id');
    fetch(url)
        .then(function (response) {
            return response.blob()
        })
        .then(function (blob) {
            // send('k', blob,fname,id)
            send_data.push('k')
            send_data.push(blob)
            send_data.push(fname)
            send_data.push(id)
        });

});



$("body").on("change", ".image", function(e){
    let files = e.target.files;
    const file11 = this.files[0];
    const fileType = file11['type'];
    const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
    console.log(file11);
    let done = function (url) {
        image.src = url;
        $modal.modal('show');
      //  send()
    };
    let reader;
    let file;
    let url;
    if (files && files.length > 0 && validImageTypes.includes(fileType)) {
        file = files[0];
        if (URL) {
            done(URL.createObjectURL(file));
        } else if (FileReader) {
            reader = new FileReader();
            reader.onload = function (e) {
                done(reader.result);
            };
            reader.readAsDataURL(file);
        }
    }
    else {
        flashMessage('unsupported media type !','red');
    }
});

$modal.on('shown.bs.modal', function () {
    cropper = new Cropper(image, {
        // aspectRatio: 1,
        viewMode:3,
        preview: '.preview',
        crop(event) {
            cropImage(
                event.detail.x,
                event.detail.y,
                event.detail.width,
                event.detail.height,
                event.detail.scaleX,
                event.detail.scaleY);
            $('.w_value').html(Math.round(event.detail.width) + 'px');
            $('.h_value').html(Math.round(event.detail.height) + 'px');
        },
    });
    // console.log(x);
}).on('hidden.bs.modal', function () {
    cropper.destroy();
    cropper = null;
    send_data = [];
});
let arr = {};
function cropImage(x,y,w,h,X,Y){
    arr = {
        'x':x,
        'y':y,
        'w':w,
        'h':h,
        'X':X,
        'Y':Y,
    };
    return arr;
}

// console.log(arr);
// function send(param,blob,fname,id) {

//     console.log(param,blob,fname,id);

    $("#crop").on('click',function(){
        console.log(send_data[2]);
        let fd = new FormData(),
            // _self =$('#med_pic')[0],
            fol = $('#fldr').val(),
            file;
        if(send_data.length > 1 && send_data[0] == 'k'){
            fd.append('param',send_data[0]);
            fd.append('file',send_data[1],send_data[2]);
        } else{
            file = $('#med_pic')[0].files[0];
            fd.append('file',file);
        }
        fd.append('folder',fol);
        fd.append('prop',JSON.stringify(arr));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'media/upload',
            type: 'post',
            // dataType: "json",
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){

                // console.log(response);
                if(response.status == 'success' && response.edited !== true){
                    let div = '<div class="img_box" data-id="'+response.id +'">' +
                        '<span aria-hidden="true" class="rem">' +
                        '<i class="fa fa-close img_del"></i></span>' +
                        '<p class="vert">' + readableBytes(response.size) +'</p>'+
                        '<img class="blah" src="'+response.path +'" />' +
                        '<a href="javascript:void(0) " style="margin-top: 1px" data-path="' + response.public_url + '">copy public path</a>' +
                        '</div>';
                    if(fol == '0'){
                        $('.img_bl').append(div);
                    } else{
                        $('.f_box[data-id='+fol+']').find('.count').text(response.cnt);
                        $('.f_data').append(div);
                    }
                    $('.modal').modal('hide');
                    flashMessage(response.message)
                    fol = 0;
                }else if(response.edited == true){
                    let d = new Date();
                    $(".img_box[data-id='" + send_data[3] + "']").find('img').attr('src', response.path+'?'+d.getTime());
                    $(".img_box[data-id='" + send_data[3] + "']").find('.vert').text(readableBytes(response.size));
                    $('.modal').modal('hide');
                    flashMessage(response.message);
                    send_data = [];
                } else{
                    flashMessage(response.error.file,'red')
                }
            },
            error: function (xhr) {
                console.log((xhr));
            }
        });
    })
// }

// add folder modal
$('.toolbar_m').click(function () {
    $('#folder_modal').modal('show');
});

$('#folder_modal #save_f').click(function () {
    let name = $('#f_name').val(),
        url = $('#folder_modal form').attr('action');
    ajaxCsrf();
    $.ajax({
        url: url,
        type: 'post',
        data: {'name': name},
        dataType: 'json',
        success: function(response){
            if(response.status == 'success'){
                $('#folder_modal').modal('hide');
                let fl = '<div class="f_box" data-id='+response.id+'>\n' +
                    '                    <div class="folder_box" >\n' +
                    '<span class="count"></span>\n' +
                    '                       <i class="fa fa-folder" aria-hidden="true" ></i><span>'+ response.name +'</span>\n' +
                    '                       </div><div class="rem_fol">delete folder</div>\n' +
                    '                   </div>';
                $('.folder_bl').append(fl);
                window.location.reload()
            }else{
                alert('folder not created');
            }
        },
    });
});

// delete image
$(document).on('click','.img_del',function () {
    let id = $(this).closest('.img_box').data('id'),
        fol = $(this).closest('.img_box').data('f');
    ajaxCsrf();
    $.ajax({
        url: 'media/delete_file',
        type: 'post',
        data: {'id': id,'folder':fol},
        dataType: 'json',
        success: function(response){
            if(response.status == 'success'){
                $('.img_box[data-id='+response.id+']').remove();
                $('.f_box[data-id='+fol+']').find('.count').text(response.cnt);
                flashMessage(response.message)
            }else{
                alert('error deleting');

            }
        },
    });
});
// enter folder
$(document).on('dblclick','.f_box',function (e) {
    if(e.target.className != 'rem_fol'){
        $('.f_level .f_data').html('')
        let id = $(this).data('id');
        $('#fldr').val(id);
        ajaxCsrf();
        $.ajax({
            url: 'media/open_folder',
            type: 'post',
            data: {'id': id},
            dataType: 'json',
            success: function(response){
                if(response.status == 'success') {
                        $.each(response.images, function (i, v) {
                            if(v.image) {
                                $('.f_level .f_data').append(
                                    '<div class="img_box" data-id="' + v.image.id + '" data-f="' + id + '">\n' +
                                    '   <span aria-hidden="true" class="rem"><i class="fa fa-close img_del"></i></span>\n' +
                                    '<p class="vert">'+ readableBytes(v.size) +' </p>'+
                                    '  <img class="blah" src="' + v.path + '">\n' +
                                    '<a href="javascript:void(0) " style="margin-top: 1px" data-path="' + v.path + '">copy public path</a>' +
                                    '</div>')
                            }
                        });
                        $('.r_level').hide();
                        // $('.toolbar_m .fa-folder').css({'color':'red'})
                        // $('.toolbar_m span').css({'color':'red'})

                        $('.toolbar_m').hide();
                        $('.f_level').show();
                        $('#r_menu').after('<span>->' + response.f_name + '</span>')
                    } else {
                        alert('error deleting');
                    }
            },
        });
    }
});

$('#r_menu').click(function () {
    $('#fldr').val('0');
    $('.f_level').hide();
    $('.r_level').show();
    $('#r_menu').siblings('span').remove();
    $('.toolbar_m').show();
});

$(document).on('mouseenter','.f_box',function (e) {
    $(this).find('.rem_fol').slideDown('fast')
});
$(document).on('mouseleave','.f_box',function (e) {
    $(this).find('.rem_fol').slideUp('fast')
});

// delete folder
$('.rem_fol').click(function () {
    let id = $(this).parent('.f_box').data('id');
    ajaxCsrf();
    $.ajax({
        url: 'media/delete_folder',
        type: 'post',
        data: {'id': id},
        dataType: 'json',
        success: function(response){
            if(response.status == 'success'){
                $('.f_box[data-id='+response.id+']').remove();
                flashMessage(response.message)
            }else{
                alert('error deleting');

            }
        },
    });
});

// copy public path
$(document).on('click','.img_box a',function () {
    var value = $(this).data('path');
    copyToClipboard(value,this);
});

function copyToClipboard(value,_this) {
    $(_this).text('copied').css('background-color', '#0a6aa1');
    var $tmpInput = $('<input>');
    $tmpInput.val(value);
    $('body').append($tmpInput);
    $tmpInput.select();
    document.execCommand('copy');
    $tmpInput.remove();
    setTimeout(function () {
        $(_this).text('copy public path').css('background-color', 'darkgrey');
    },2000)
}
//

$(document).on('click','.img_box a',function () {
    var value = $(this).data('path');
    copyToClipboard(value,this);
});

function copyToClipboard(value,_this) {
    $(_this).text('copied').css('background-color', '#0a6aa1');
    var $tmpInput = $('<input>');
    $tmpInput.val(value);
    $('body').append($tmpInput);
    $tmpInput.select();
    document.execCommand('copy');
    $tmpInput.remove();
    setTimeout(function () {
        $(_this).text('copy public path').css('background-color', 'darkgrey');
    },2000)
}

function ajaxCsrf() {
    return $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function readableBytes(bytes) {
    var i = Math.floor(Math.log(bytes) / Math.log(1024)),
        sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    return (bytes / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + sizes[i];
}

