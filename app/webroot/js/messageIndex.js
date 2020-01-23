$(document).ready(function(){
    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        var id = $(this).attr('value');

        $.ajax({
            type: "POST",
            url: '../../messenger/messages/delete',
            cache: false,
            data: {
                'id': id
            },
            success: function(result) {
                $('#conversations').fadeOut();
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })

    $('#readMoreReadLess').readMoreReadLess();
})

