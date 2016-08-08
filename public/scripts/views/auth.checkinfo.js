/**
 * Created by HJLEE on 2016. 6. 20..
 */
initEvent();

$(document).ready(function () {
    init();
    
})


function init() {
     Datebox();
     Cropbox();
    $(":file").filestyle();
}

function  initEvent() {
    $()
    $('#btn-prev').on('click', function () {
        var step = $('.step.on').data('step') - 1;
        step = step < 1? 1: step;

        $('.step.on').removeClass('on');
        $('.step[data-step='+step+']').addClass('on');

        if(step < $('.step').length) {
            $('#btn-next span').html('Next')
        }
    })
    $('#btn-next').on('click', function () {

        if($('.step.on').hasClass('Cropbox')){
            $('#btnCrop').trigger('click')
        }

        var step = $('.step.on').data('step') + 1;

        if(step > $('.step').length) {
            $.ajax({
                type: 'post',
                url: '/user/checkinfo',
                data: {
                    nick_name: $('#nick_name').val(),
                    birth: $('#birth').val(),
                    gender: $('#gender .active input').val(),
                    job: $('#job').val(),
                    city: $('#locale').val(),
                    photo: $('#photo').val(),
                    locale: $('#locale').val()
                },
                success: function (res) {
                    alert('Thank you for sharing your information.')
                    location.href = '/home';
                }
            })
        }
       else {
            $('.step.on').removeClass('on');
            $('.step[data-step='+step+']').addClass('on');

            if(step == $('.step').length) {
                $('#btn-next span').html('Finish');
            }
            else{
                $('#btn-next span').html('Next')
            }
        }
    })

}