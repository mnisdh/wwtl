/**
 * Created by HJLEE on 2016. 6. 20..
 */
var reply_id = -1;

initEvent();

$(document).ready(function () {
    init();
})


function init() {
    $('#sel-type').trigger('change');
    getReply();
}

function  initEvent() {
    $('#sel-type').on('change',function () {
        if($(this).val() > 0)
        {
            $('.rate, #info').hide();
            $('.rate[data-type='+$(this).val()+'], #recent').show();
        }
    })

    $('.rate').on('click', function () {
        $('#info').show();
        $('#recent').hide();
        $('#view-rate #score').html($(this).data('score'));
        $('#view-rate #year span').html($(this).data('year'));
        $('#view-rate #dt span').html($(this).data('dt'));
        $('#view-rate #comment span').html($(this).data('comment'));
    })
    
    $('#reply-submit').on('click', function () {
        setReply();
    })
}

function getReply() {
    $.ajax({
        type: 'get',
        url: '/rate/reply/' + $('#target').val(),
        success: function (res) {

            var tmp = _.template($('#tmpl-reply').html());
            $('#list-reply').html(tmp({data : res}));


            $('#list-reply .update').on('click', function () {
                var obj = $(this).parents('.reply-item');
                reply_id = $(this).data('id')
                $('#reply-comment').val($('.comment', obj).text())
            })
            $('#list-reply .delete').on('click', function () {
                if(confirm('Delete this comment?'))
                {
                    reply_id = $(this).data('id');
                    deleteReply();
                }
            })
        }
    })
}

function setReply(){
    $.ajax({
        type: 'post',
        url: '/rate/reply/' + reply_id,
        data: {
            target_seq : $('#target').val(),
            comment: $('#reply-comment').val()
        },
        success: function (res) {
            getReply();
            $('#reply-comment').val('')
            reply_id = -1;
        }
    })
}

function deleteReply() {
    $.ajax({
        type: 'put',
        url: '/rate/reply/' + reply_id,
        success: function (res) {
            getReply();
            reply_id = -1;
        }
    })
}
