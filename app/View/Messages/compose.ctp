<script>
    var url = '../messages/send';
    var redirect = '../messages/';
    var page = 'compose';
</script>

<?php 
    echo $this->Html->script(array(
        'jquery', 
        'sendMessage',
        'select2.min'), FALSE);
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
    $(function() {
        $('#people').select2();
    })
</script>