$(document).ready(function(event){

    window.ctr = 1;

    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#people').val();
        var message = $('#message').val();
        var data;

        if(message == ''){
            return alert('Please leave a message');
        }
        else{

            if(id == null) 
                id = receiverId;
            else 
                id = id;
    
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
                    if(page == 'conversation'){ // initialized in conversation.ctp
                        location.reload();
                    }
                    else{
                        window.location.href = redirect;
                    }
                },      
                error: function (response, desc, exception) {
                    alert(exception);
                }
            });
        }
    })

    $('#show-more').on('click', function(e){
        e.preventDefault();

        $.ajax({
            type: "POST",
            url: '../../messages/more',
            cache: false,
            data: {
                'id': receiverId,
                'offset': (ctr) * 10
            },
            success: function(html) {
                $(html).insertAfter($('.container').last());
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });

        ctr++;
    })

    $('#search').keyup(function(e){
        e.preventDefault();

        var keyword = $(this).val();

        $.ajax({
            type: "POST",
            url: '../../messages/search',
            cache: false,
            data: {
                'id': receiverId,
                'keyword': keyword
            },
            success: function(html) {
                $('.container').remove();
                $(html).insertAfter($('#search'));
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })

    $('#people').select2();
})