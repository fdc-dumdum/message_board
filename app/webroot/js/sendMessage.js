
$(document).ready(function(event){

    window.ctr = 1;

    if(page != 'compose'){
        fetchData(0);
    }

    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#people').val();
        var message = $('#message').val();

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

        var offset = ctr * 10;

        fetchData(offset);
        ctr++;
    })

    $('#search').keyup(function(e){
        
        e.preventDefault();

        var keyword = $(this).val();
        var no_data = '<div class="container">No results found</div>';

        $.ajax({
            type: "POST",
            url: '../../messages/search',
            cache: false,
            data: {
                'id': receiverId,
                'keyword': keyword
            },
            success: function(response) {
                if(response == ""){
                    $('.container').remove();
                    $(no_data).insertAfter($('#search'));
                }
                else{
                    $('.container').remove();
                    $(response).insertAfter($('#search'));
                }
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })
    
    function fetchData(offset){
        $.ajax({
            type: "POST",
            url: '../../messages/conversation/' + receiverId,
            cache: false,
            data: {
                'id': receiverId,
                'offset': offset
            },
            success: function(response) {
                if(response == ""){
                    alert('No more data to be loaded');
                }
                else{
                    $('.container').length 
                    ? $(response).insertAfter($('.container').last()) 
                    : $(response).insertAfter($('#search'));
                }
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    }

})