
$(document).ready(function(){
    $(document).on('click', '.delete', function(e){
        e.preventDefault();
        var id = $(this).attr('value');
        var _this = $(this);

        $.ajax({
            type: "POST",
            url: '../../messenger/messages/delete',
            cache: false,
            data: {
                'id': id
            },
            success: function(result) {
                _this.parent('div.container').fadeOut(); 
            },      
            error: function (response, desc, exception) {
                alert(exception);
            }
        });
    })

    // Alternative solution for now
    $('.content').on('click', function(e){
        $(this).css('white-space') == 'nowrap'
        ? $(this).css({'white-space': 'normal'}) 
        : $(this).css({'white-space': 'nowrap' })
    })

})

