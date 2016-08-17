$(document).ready(function () {
    init();
    initEvent();
})

var map;
function init(){
   
}
function initEvent(){
    $('#chk-country').on('change',function () {
        if($(this).is(":checked")){
            $('#country').removeAttr('disabled')
        }
        else{
            $('#country').attr('disabled', true)
        }
    })

    $('.featured').on('change', function () {
        $('#list-featured a').unbind('click');
        var tmp = _.template($('#tmpl-featured-btn').html());
        $('#list-featured').append(tmp({item_nm: $("option:selected", this).text(), item_cd: $("option:selected", this).val()}))
        var type = '';
        $('#list-featured a').bind('click', function () {
            $(this).remove();
            type = '';
            _.each($('.type'), function (v, i) {
                type += $(v).data('cd') + '|';
            })
            search(type.substr(0, type.length-1));
        })
        _.each($('.type'), function (v, i) {
            type += $(v).data('cd') + '|';
        })
        search(type.substr(0, type.length-1));
    })

    // search
    $('#search').on('click', function () {
        search();
    })
    $('#target').on('keyup', function (e) {
        if(e.keyCode == 13)
        search();
    })
    
    // search-all
    $('#search-all').on('click', function () {
        search_all();
    })
    $('#val-all').on('keyup', function (e) {
        if(e.keyCode == 13)
            search_all();
    })
    
    // search-detail
    $('#btn-condi-add').on('click', function () {
        $(".search-detail").append($('#tmpl-condition').html())

        $('.condi-del').unbind('click');
        $('.condi-del').bind('click', function () {
            if($('.condition').length > 1)
                $(this).parent().remove();
        })

        $('.sel-condition').unbind('change');
        $('.sel-condition').bind('change',function () {
            $('.val-condition', $(this).parent()).removeClass('on');
            $('.val-condition.'+ $(this).val(), $(this).parent()).addClass('on');
        });
    })
    $('.sel-condition').bind('change',function () {
        $('.val-condition', $(this).parent()).removeClass('on');
        $('.val-condition.'+ $(this).val(), $(this).parent()).addClass('on');
    });
    $('#btn-condi-remove').on('click', function () {
        var condi = $( ".condition" ).eq(0);
        $('.condition').remove();
        condi.appendTo(".search-detail");
    })

    $('#btn-condi-search').on('click', function () {
        search_detail();
    })
}

function search(type) {
    $.ajax({
        type: 'post',
        url:'/rate/search',
        data: {
            query1 : '%'+$('#target').val()+'%',
            type : type||''
        },
        success:function (res) {
            var tmp = _.template($('#tmpl-search').html());
            $('#search-board').html(tmp({data: res}));
        }
    })
}

function search_all(){
    $.ajax({
        type: 'post',
        url: 'rate/searchall',
        data: {
            val : $('#val-all').val()
        },
        success: function (res) {
            var tmp = _.template($('#tmpl-result-all').html());
            $('#result-all').html(tmp({data: res}))
        }
    })
}

function search_detail() {
    $.ajax({
        type: 'post',
        url: 'rate/searchdetail',
        data: {
            name: $('.c-name.on').length > 0?$('.c-name.on').val():'',
            job: $('.c-job.on').length > 0?$('.c-job.on').val():'',
            type: $('.c-featured.on').length > 0? $('.c-featured.on').val():'',
            birth: $('.c-birth.on').length > 0? $('.c-birth.on').val():''
        },
        success: function (res) {
            var tmp = _.template($('#tmpl-result-detail').html());
            $('#result-detail').html(tmp({data: res}))
        }
    })
}


function initMap() {
    $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?')
        .done(function (location) {
            var loc = location;
            $('#country').val(loc.country_code)
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: loc.latitude, lng: loc.longitude},
                zoom: 6
            });
            $.ajax({
                type:'post',
                url:'/rate/searchmap',
                data: {
                    country: loc.country_code
                },
                success: function (res) {
                    _.each(res, function (v, i) {
                        var marker = new google.maps.Marker ({
                            icon: {
                                url:'/img/loc.png'
                            },
                            position: {lat: parseFloat(v.lat), lng: parseFloat(v.lng)},
                            title: v.nick_name,
                            label: (i+1).toString()});

                        var infowindow = new google.maps.InfoWindow({
                            content: '<a href="/rate/view/'+v.seq+'"><img style="border:1px solid #999; margin-right:5px;width:25px; height:25px;" src="'+v.photo+'" />'+v.nick_name+'</a>'
                        });
                        google.maps.event.addListener(marker,'click',function(){
                            infowindow.open(map,marker);
                        });
                        marker.setMap(map);
                    })
                }
            })
        });
}
