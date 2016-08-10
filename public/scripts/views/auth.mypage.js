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
                modal({
                    type: 'alert',
                    title: 'WWTL',
                    text: 'Complete update your information.',
                    callback: function(result) {
                        location.reload();
                    }
                })
            }
        })
    })
}