$(document).on('click','.edit', function(e) {
    e.preventDefault();
    let td = $(this).parents('td').siblings('td')
    let val = td.text()
    $(this).parents('td').find('.del').hide();
    $(this).parents('td').append('<input class="btn btn-sm btn-success pull-right cancel" type="submit" value="Cancel" >');
    td.empty()
    td.append('<input type="text" name="menuName" class="form-control" value="'+ val +'"/>')
    $(this).siblings('.save').css('display','block')
    $(this).remove()
    $('input[name="menuName"]').keyup(function () {
        $('input[name="menu_name"]').val($(this).val())
    });
    $('.cancel').one('click',function () {
        $(this).hide();
        $(this).parents('td').siblings('td').find('input[name="menuName"]').remove();
        $(this).parents('td').siblings('td').text(val);
        $(this).parents('td').find('.save').css('display','none');
        $(this).parents('td').find('.dw').append('<input class="btn btn-sm btn-primary pull-right edit" type="submit" value="Edit">')
        $(this).parents('td').find('.del').show();
    })
});
$(document).ready(function () {
    $('.alert-success,.alert-danger').fadeOut(5000)
})
