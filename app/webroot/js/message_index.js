$(document).ready(function(){
    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        var id = $(this).attr('value');

        $.ajax({
            type: "POST",
            url: '../messages/delete/',
            cache: false,
            data: {
                'id': id
            },
            success: function(result) {
                $('#test').fadeOut();
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })
})