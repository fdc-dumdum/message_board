$(document).ready(function(event){
    $('.js-example-basic-multiple').select2();
    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#users').val();
        var message = $("#message").val();

        $.ajax({
            type: "POST",
            url: '../messages/send',
            cache: false,
            data: {
                'id': id,
                'message': message
            },
            success: function(result) {
                console.log(result);
                // window.open('/app/webroot/reviews/add/'+id,'_self');
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })
})