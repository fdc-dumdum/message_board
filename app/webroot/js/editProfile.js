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

    $('#password').keypress(function(event){

        var password = $(this).val();

        var passwordEl = '<input name="data[User][new-password]" type="password" id="new-password" placeholder="Enter new password" style="margin-top: 10px">';
        var confirm_passwordEl = '<input name="data[User][confirm-password]" type="password" id="confrim-password" placeholder="Confirm your new password" style="margin-top: 10px">';

        if(event.keyCode == 13) {
          event.preventDefault();

            if(password == ''){
                alert("Please enter current password");
                $('#password').removeAttr('style');
                $('#new-password').remove();
                $('#confrim-password').remove();
            }
            else{
                $.ajax({
                    type: "POST",
                    url: '../../users/checkPassword',
                    cache: false,
                    data: {
                        'password': password
                    },
                    success: function(response) {
                        if(response == 1){
                            if($('#new-password').length){
                                return false;
                            }
                            else{
                                $('#password').css({
                                    "backgroundColor":"lightgreen"
                                });
                                $(passwordEl).insertAfter($('#password'));
                                $(confirm_passwordEl).insertAfter($('#new-password'));
                            }
                        }
                        else{
                            $('#password').css({
                                "backgroundColor":"red"
                            });
                            $('#new-password').remove();
                            $('#confrim-password').remove();
                        }
                    },      
                    error: function (response, desc, exception) {
                        alert(exception);
                    }
                });
            }
          return false;
        }
      });

    $('#birthdate').datepicker();
})