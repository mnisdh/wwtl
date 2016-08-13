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
            $('.rate, .info').hide();
            $('.rate[data-type='+$(this).val()+']').show();
            $('.rate[data-type='+$(this).val()+']').eq(0).trigger('click')
        }
        else{
            $('.rate').show();
            if($('.rate').length > 0)
                $('.rate').eq(0).trigger('click')
        }
    })
    $('.rate').on('click', function () {
        $('.rate.on').removeClass('on');
        $('#list-user .info').slideUp();
        $(this).addClass('on');
        $(this).next().slideDown();
        $('#view-rate #score').html($(this).data('score'));
        $('#view-rate #year span').html($(this).data('year'));
        $('#view-rate #dt span').html($(this).data('dt'));
        $('#view-rate #comment span').html($(this).data('comment'));
        getChart($(this).data('target'), $(this).data('rate'))
    })
    
    $('#reply-submit').on('click', function () {
        setReply();
    })
}

function getChart(target_seq, rate_id){
    $.ajax({
        url: '/rate/chart',
        data:{
            target_seq : target_seq,
            rate_id : rate_id
        },
        success: function (res) {
            var alables = [], adatas = [];
            var lhlables = [], lhdatas = [];
            var hllables = [], hldatas = [];

            _.each(res, function(v, i){
                alables.push(v.name);
                adatas.push(v.score);
            })

            var lh = _.sortBy(res, 'score');
            _.each(lh, function (v, i) {
                if(i<5){
                    lhlables.push(v.name);
                    lhdatas.push(v.score);
                }
            })
            var hl = _.sortBy(res, function(v){
                return v.score * -1;
            });
            _.each(hl, function (v, i) {
                if(i<5){
                    hllables.push(v.name);
                    hldatas.push(v.score);
                }
            })

            dispChart(hllables, hldatas);
            $('#sel-sort').unbind('change');
            $('#sel-sort').bind('change', function () {
                if($(this).val() == 'hl'){
                    dispChart(hllables, hldatas);
                }else{
                    dispChart(lhlables, lhdatas);
                }
            })

            $('#chart-all').unbind('click');
            $('#chart-all').bind('click',function(){
                modal({
                    type: 'alert',
                    title: 'WWTL',
                    text: '<div id="popChart"><canvas id="allChart" width="50" height="50"></canvas></div>',
                    onShow: function(r) {
                        dispAllChart(alables, adatas);
                    }
                })
            });
        }
    })
}

function dispAllChart(labels, datas){
    $('#popChart').empty();
    $('#popChart').append('<canvas id="allChart" width="50" height="50"></canvas>');
    var ctx = document.getElementById("allChart");
    var myChart = new Chart(ctx, {
        type: 'horizontalBar',
        data: {
            labels: labels,
            datasets: [{
                data: datas,
                borderWidth: 1
            }]
        },
        options:{
            legend: {
                display: false
            }
        }
    });
}

function dispChart(labels, datas){
    $('#chart').empty();
    $('#chart').append('<canvas id="myChart" width="50" height="50"></canvas>');
    var ctx = document.getElementById("myChart");
    var myChart = new Chart(ctx, {
        type: 'polarArea',
        data: {
            //labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            labels: labels,
            datasets: [{
                //data: [12, 19, 3, 5, 2, 3],
                data: datas,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                    //'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                    //'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options:{
            legend: {
                position: 'bottom',
                labels:{
                    boxWidth: 10
                }
            }
        }
    });

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
