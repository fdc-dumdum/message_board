<script>
    var url = '../messages/send';
    var redirect = '../messages/';
</script>

<?php 
    echo $this->Html->script(array(
        'jquery', 'sendMessage', 'select2.min'), FALSE);
?>

<div id="success"></div>
<h2>New Message</h2>

<?php
    echo $this->Form->create('Message');
    echo '<select class="js-example-basic-multiple" style="width: 200px" id="people">';

        foreach($users as $user) :
            echo '<option value="'.$user['User']['id'].'">'.$user['User']['name'].'</option>';
        endforeach;
        
    echo '</select>';
    echo $this->Form->input('content', array('id' => 'message'));
    echo $this->Form->button('Reply Message', array(
        // 'before' => $this->Js->get('#sending')->effect('fadeIn'),
        // 'success' => $this->Js->get('#sending')->effect('fadeOut'),
        // 'update' => '#success',
        // 'url' => 'send',
        'id' => 'send-btn'
    ));
    echo $this->Form->end();
?>
<div id="sending" style="display: none; background-color: lightgreen">Sending...</div>
<script>
    $(document).ready(function(event){
    window.counter = 1;

    $('#send-btn').on('click', function(e){
        e.preventDefault();

        var id = $('#people').val();
        var message = $('#message').val();

        $.ajax({
            type: "POST",
            url: "<?php echo Router::url(array('controller' => 'messages', 'action' => 'send')); ?>",
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
            url: "<?php echo Router::connect(array('controller' => 'messages', 'action' => 'send')) ?>",
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
</script>
