$(document).ready(function(){
    $('input[type=submit]').click(function(e){
        var form = $('#UserCreateForm')[0];
        var data = new FormData(form);

        
        if(data.get('data[User][name]') == ""
        || data.get('data[User][email]') == ""
        || data.get('data[User][password]') == ""
        || data.get('data[User][confirm-password]') == ""){
            return alert('All fields are required');
        }
        else if(data.get('data[User][name]').length < 5 || data.get('data[User][name]').length > 20){
            return alert('Name must be 5 - 20 characters long');
        }
        else{
            if(data.get('data[User][password]')  != data.get('data[User][confirm-password]')){
                return alert('Password does not match');
            }
        }
    })
})