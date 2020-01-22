$(document).ready(function(event){
    window.counter = 1;


    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#people').val();
        var message = $('#message').val();

        $.ajax({
            type: "POST",
            url: url,
            cache: false,
            data: {
                'id': id,
                'message': message
            },
            success: function(result) {
                alert(result);
                window.location.href = redirect;
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })

    $('#show-more').on('click', function(e){
        e.preventDefault();
        var offset = (counter - 1) * 5;

        $.ajax({
            type: "POST",
            url: '../../messages/pagination',
            cache: false,
            dataType: 'html',
            data: {
                'offset': offset
            },
            success: function(result) {
                console.log(result);
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
        
        counter++;
    })

    $('#people').select2();
})