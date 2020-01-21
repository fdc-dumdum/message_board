$(document).ready(function(event){
    window.counter = 1;

    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#people').val();
        var message = $('#message').val();

        $.ajax({
            type: "POST",
            url: '../messages/send',
            cache: false,
            data: {
                'id': id,
                'message': message
            },
            success: function(result) {
                alert(result);
                window.location.href = "../messages/";
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })

    $('#show-more').on('click', function(e){
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: '<?php echo Router::connect(array("controller" => "messages", "action" = "")) ?>',
            cache: false,
            data: {
                'id': id,
                'message': message
            },
            success: function(result) {
                alert(result);
                window.location.href = "../messages/";
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
        
        counter++;
    })

    $('#people').select2();
})