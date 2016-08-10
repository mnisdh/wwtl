/**
 * Created by HJLEE on 2016. 6. 20..
 */
initEvent();

$(document).ready(function () {
    init();
    
})


function init() {
     Datebox();
     Cropbox($('#oPhoto').val());
    $(":file").filestyle();
}

function  initEvent() {
    $('#btn-prev').on('click', function () {
        var step = $('.step.on').data('step') - 1;
        step = step < 1? 1: step;

        $('.step.on').removeClass('on');
        $('.step[data-step='+step+']').addClass('on');

        if(step < $('.step').length) {
            $('#btn-next span').html('Next')
        }
    })
    $('#btn-next').on('click', function () {

        if($('.step.on').hasClass('Cropbox')){
            $('#btnCrop').trigger('click')
        }

        var step = $('.step.on').data('step') + 1;

        if(step > $('.step').length) {
            if($('#locale_cd').val() == '')
            {
                modal({
                    type: 'alert',
                    title: 'Alert',
                    text: 'Please, select location autocomplate list.'
                })
            } else{
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
                        locale: $('#locale').val(),
                        locale_cd : $('#locale_cd').val()
                    },
                    success: function (res) {
                        modal({
                            type: 'alert',
                            title: 'Alert',
                            text: 'Thank you for sharing your information.'
                        })
                        location.href = '/home';
                    }
                })
            }
        }
       else {
            $('.step.on').removeClass('on');
            $('.step[data-step='+step+']').addClass('on');

            if(step == $('.step').length) {
                $('#btn-next span').html('Finish');
            }
            else{
                $('#btn-next span').html('Next')
            }
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
