/**
 * Created by HJLEE on 2016. 6. 20..
 */
initEvent();

$(document).ready(function () {
    init();
})


function init() {
    getType();
}

function  initEvent() {
    $('#sel-type').on('change', function () {
        getType();
    });
    
    $('#btn-update').on('click', function () {
        var items='', scores = '';
        _.each($('.slider'), function (v, i) {
            if(!$(v).hasClass('slider-disabled')){
                items += $(v).next().data('item') + '|'
                scores += $(v).next().val() + '|'
            }
        })
        $.ajax({
            type: 'post',
            url: '/rate/data/' + $('#sel-type option:selected').val(),
            data: {
                target_seq : $('#target-seq').val(),
                items : items.substr(0, items.length-1),
                scores : scores.substr(0, scores.length-1),
                year: $('#knew-year option:selected').val(),
                comment : $('.txt-comment').val()
            },
            success: function (res) {
                modal({
                    type: 'alert',
                    title: 'WWTL',
                    text: 'Rating complete!',
                    callback: function () {
                        location.href = '/rate/view/' + $('#target-seq').val();
                    }
                })
            }
        })
    })
}

function getType() {
    $.ajax({
        url: '/rate/type/' + $('#sel-type option:selected').val(),
        success: function (res) {
            if(res != null){
                var tmp = _.template($('#tmpl-item').html());
                $('#tbl-item').html(tmp({data : res}));
                $('.slider-item').slider();

                $('.btn-na').on('click', function () {
                    if ($(this).hasClass('on')) {
                        $(this).removeClass('on');
                        $('#item' + $(this).data('item')).slider('enable');
                    }
                    else {
                        $(this).addClass('on');
                        $('#item' + $(this).data('item')).slider('disable');
                    }
                })
            }
        }
    })
}