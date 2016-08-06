$.ajaxSetup(
    {
        headers:
        {
            'X-CSRF-Token': $('input[name="_token"]').val()
        }
    });


function Datebox(date) {
    var date;
    if(date != null){
        date = date.substr(0,10)
    }
    else{
        date = moment().format('YYYY-MM-DD')
    }
    $("#birth").dateDropdowns({
        defaultDate: date,
        minYear: 1700
    });
}

function Cropbox(img) {
    window.onload = function() {
        var options =
        {
            imageBox: '.imageBox',
            thumbBox: '.thumbBox',
            spinner: '.spinner',
            imgSrc: img || '/img/user.png'
        }
        var cropper = new cropbox(options);

        document.querySelector('#file').addEventListener('change', function(e){
            e.preventDefault();
            var reader = new FileReader();
            reader.onload = function(e) {
                options.imgSrc = e.target.result;
                cropper = new cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);
            //this.files = [];
        })
        document.querySelector('#btnCrop').addEventListener('click', function(){
            var img = cropper.getDataURL('image/png');
            $('#photo').val(img);
            //document.querySelector('.cropped').innerHTML += '<img src="'+img+'">';
        })

        var zoomSlider = new Slider("#slider-zoom");
        $('#file').on('change', function () {
            zoomSlider.enable();
        });

        zoomSlider.on("slide", function(slideEvt) {
            cropper.zoom(slideEvt);
        });
    };
}