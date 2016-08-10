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
        if($('#locale_cd').val() == '')
        {
            modal({
                type: 'alert',
                title: 'WWTL',
                text: 'Please, select location autocomplate list.'
            })
        } else {
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
                    locale: $('#locale').val(),
                    locale_cd: $('#locale_cd').val()
                },
                success: function (res) {
                    if($('#seq').val() == -1){
                        location.href = '/rate/rate/' + res;
                    } else{
                        location.href = '/rate/view/' + res;
                    }
                }
            })
        }
    })
}


// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

var autocomplete;
function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('locale')),
        {types: ['geocode']});

    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocomplete.addListener('place_changed', function(){
        var place = autocomplete.getPlace();
        $('#locale_cd').val(place.place_id)
    });
}