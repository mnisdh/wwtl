$(document).ready(function () {
    init();
    initEvent();
})

var map;
function init(){
    if(location.href.indexOf('find')>0){
        $(window).scrollTop(600)
        $('#target').focus();
    }
}
function initEvent(){
    $('#country li').on('click', function () {
        var geocoder = new google.maps.Geocoder();
        var location = $(this).data('val');
        $('#sel-country').html($(this).text())
        $('#sel-country').data('val', location)
        if(location == ''){
            map.setCenter(new google.maps.LatLng(50, 0));
            map.setZoom(2);
        } else {
            geocoder.geocode( { 'address': location }, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    map.setZoom(6);
                } else {
                    alert("Could not find location: " + location);
                }
            });
        }
        search();
    })
    
    $('#search-typ li').on('click', function () {
        $('#sel-search-typ').data('val', $(this).data('val'));
        $('#sel-search-typ').html($(this).text())
        if($(this).data('val') == 'all'){
            search();
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
    $('#btn-search').on('click', function () {
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

    $('.res-type a').on('click', function () {
       if(!$(this).hasClass('on')){
            $('.res-type a.on').removeClass('on');
            $(this).addClass('on')

            search()
        }
    })
}

var marker = [];
var autocomplete;
var alat, alng;

// function search(type) {
//     $.ajax({
//         type: 'post',
//         url:'/rate/search',
//         data: {
//             query1 : '%'+$('#target').val()+'%',
//             query2 : alat != null ? $('#sel-country').data('val') : '',
//             type : type||''
//         },
//         success:function (res) {
//             console.log(res)
//             var tmp = _.template($('#tmpl-search').html());
//             $('#search-board').html(tmp({data: res}));
//             if(marker.length > 0)
//             {
//                 _.each(marker, function (v, i) {
//                     marker[i].setMap(null);
//                 })
//                 marker = [];
//             }
//
//             if(alat != null)
//             {
//                 map = new google.maps.Map(document.getElementById('map'), {
//                     center: {lat: alat, lng: alng},
//                     zoom: 6
//                 });
//             }
//             _.each(res, function (v, i) {
//                 marker[i] = new google.maps.Marker ({
//                     icon: v.photo,
//                     animation: google.maps.Animation.DROP,
//                     map: map,
//                     position: {lat: parseFloat(v.lat), lng: parseFloat(v.lng)},
//                     title: v.nick_name,
//                     optimized:false });
//
//                 var infowindow = new google.maps.InfoWindow({
//                     content: '<a href="/rate/view/'+v.seq+'"><img style="border:1px solid #999; margin-right:5px;width:25px; height:25px;" src="'+v.photo+'" />'+v.nick_name+'</a>'
//                 });
//                 google.maps.event.addListener(marker,'click',function(){
//                     infowindow.open(map,marker);
//                 });
//                 //marker[i].setMap(map);
//             })
//             var myoverlay = new google.maps.OverlayView();
//             myoverlay.draw = function () {
//                 this.getPanes().markerLayer.id='markerLayer';
//             };
//             myoverlay.setMap(map);
//
//         }
//     })
// }

function search() {
    $.ajax({
        type: 'post',
        url:'/rate/search',
        data: {
            typ : $('#sel-search-typ').data('val'),
            country: $('#sel-country').data('val'),
            val: $('#target').val(),
            res: $('.res-type a.on').data('val')
        },
        success:function (res) {

            var target = _.groupBy(res, function (v) {
                return v.seq;
            })

            var tmp = _.template($('#tmpl-search').html());
            $('#search-board').html(tmp({data: target, res: $('.res-type a.on').data('val')}));
            if(marker.length > 0)
            {
                _.each(marker, function (v, i) {
                    marker[i].setMap(null);
                })
                marker = [];
            }

            if(alat != null)
            {
                map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: alat, lng: alng},
                    zoom: 6
                });
            }
            _.each(res, function (v, i) {
                marker[i] = new google.maps.Marker ({
                    icon: v.photo,
                    animation: google.maps.Animation.DROP,
                    map: map,
                    position: {lat: parseFloat(v.lat), lng: parseFloat(v.lng)},
                    title: v.nick_name,
                    optimized:false });

                var infowindow = new google.maps.InfoWindow({
                    content: '<a href="/rate/view/'+v.seq+'"><img style="border:1px solid #999; margin-right:5px;width:25px; height:25px;" src="'+v.photo+'" />'+v.nick_name+'</a>'
                });
                google.maps.event.addListener(marker,'click',function(){
                    infowindow.open(map,marker);
                });
                //marker[i].setMap(map);
            })
            var myoverlay = new google.maps.OverlayView();
            myoverlay.draw = function () {
                this.getPanes().markerLayer.id='markerLayer';
            };
            myoverlay.setMap(map);

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
            console.log(res)
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


function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('locale')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', function(){
        $('#country').attr('disabled', true)
        $("#country").prop("checked", false);

        var place = autocomplete.getPlace();
        _.each(place.address_components, function (v, i) {
            if(v.types[0] == 'country')
                $('#country').val(v.short_name)
        })

        alat = place.geometry.location.lat();
        alng = place.geometry.location.lng();
        search();
    });
}



function initMap() {
    $.getJSON('https://geoip-db.com/json/geoip.php?jsonp=?').done(function (location) {
        var loc = location;

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: loc.latitude, lng: loc.longitude},
            zoom: 6
        });

        $('#sel-country').data('val', loc.country_code)
        $('#sel-country').html(loc.country_name)

        search();
    });
    //initAutocomplete();
}
