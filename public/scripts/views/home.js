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
        $( ".condition" ).clone().appendTo( ".search-detail" );
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
            $('#target-board').hide();
            $('#search-board').show();
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


function initMap() {
    $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?')
        .done(function (location) {
            var loc = location;
            $('#country').val(loc.country_code)
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: loc.latitude, lng: loc.longitude},
                zoom: 6
            });
        });
}
