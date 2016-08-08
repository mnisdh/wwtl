var param = {};

$(document).ready(function () {
    init();
    initEvent();
})

function init(){
    getData();
}

function initEvent(){
    $('#txt-name').on('keyup', function() {
        if ($(this).val() != '') {
            $('#btn-submit').removeClass('disabled');
        }
        else {
            $('#btn-submit').addClass('disabled');
        }
    })

    $('#btn-submit').on('click', function () {
        param.query = 'create';
        param.name = $('#txt-name').val();
        param.use_yn  = 'Y';
        param.idx = $('#tbl-ratetype tbody tr').length;
        setData();
    })
}

function getData(){
    $.ajax({
        url: '/admin/data/ratetype/0',
        success: function (res) {
            if(res.length> 0){
                var tmp = _.template($('#tmpl-ratetype').html());
                $('#tbl-ratetype tbody').html(tmp({data : res}));
                $('.update-name, .btn-up, .btn-down').unbind('click');
                $('.chk-use').unbind('change');
                $('.update-name').bind('click', function(){
                    var obj = $(this).parents('tr');
                    param.query = 'update_name';
                    param.rate_type = obj.find('.rate_type').html();
                    param.name = obj.find('.txt-name').val();
                    setData();
                });
                $('.chk-use').bind('change', function(){
                    var obj = $(this).parents('tr');
                    param.query = 'update_use';
                    param.rate_type = obj.find('.rate_type').html();
                    param.use_yn  = $(this).is(':checked') ? 'Y':'N';
                    setData();
                });
                $('.btn-up').bind('click', function () {
                    var obj = $(this).parents('tr');
                    if(obj.index() > 0)
                    {
                        param.rate_type = obj.find('.rate_type').html();
                        obj.prev().before(obj);
                        param.query = 'up';
                        setData();
                    }
                })
                $('.btn-down').bind('click', function () {
                    var obj = $(this).parents('tr');
                    if(obj.index() < $('#tbl-ratetype tbody tr').length - 1){
                        param.rate_type = obj.find('.rate_type').html();
                        obj.next().after(obj);
                        param.query = 'down';
                        setData();
                    }
                })
            }
        }
    })
}

function setData(){
    $.ajax({
        url: '/admin/data/ratetype',
        type: 'post',
        data: param,
        success: function () {
            getData();
        }
    })
}