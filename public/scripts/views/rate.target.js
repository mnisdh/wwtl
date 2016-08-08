/**
 * Created by HJLEE on 2016. 6. 20..
 */
initEvent();

$(document).ready(function () {
    init();
})


function init() {
     Datebox($('#birth').val());
     Cropbox($('#photo').val());
    $(":file").filestyle();
}

function  initEvent() {
    $('#btn-update').on('click', function () {
        $('#btnCrop').trigger('click');
        $.ajax({
            type: 'post',
            url: '/rate/target/' + $('#seq').val(),
            data: {
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                nick_name: $('#nick_name').val(),
                birth: $('#birth').val(),
                gender: $('#gender .active input').val(),
                job: $('#job').val(),
                photo: $('#photo').val(),
                locale: $('#locale').val()
            },
            success: function (res) {
                location.href = '/rate/rate/' + res;
            }
        })
    })
}