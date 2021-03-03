$(document).ready(function () {
    setTimeout(function () {
        $('.alert').fadeOut('1000')
    }, 2000)
})

// function flashMessage(message, color = '#ff6f36') {
//     let sss = [];
//     if (typeof message === 'object') {
//         // iteration(message)
//         for (let i = 0; i < message.length; ++i) {
//             sss.push(message[i])
//         }
//     }
//     $.each(sss, function (i, v) {
//         setTimeout(function () {
//             iteration(v, 'red')
//         }, 5000)
//     })
// }
//
// function iteration(message,color) {
//     $('.flash-modal p').html(message);
//     let width = $('.flash-modal p').width();
//     $('.flash-modal').css({'right': '5px', 'transition': '1s', 'background-color': color});
//     setTimeout(function () {
//         $('.flash-modal').css({'right': -width-50, 'transition': '1s'})
//     }, 3000)
// }

