$(document).ready(function(){
    $('#UserFile').change(function(e){
        fileReader(this);
    })

    function fileReader(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#image-viewer').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#shet').keypress(function(e){
        alert();
    })

    $('#birthdate').datepicker();
})