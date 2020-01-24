<?php 
    echo $this->Html->script(array(
        'jquery',
        'sendMessage', 
        'select2.min'
    ), FALSE);
?>

<script>
    var url = '../../messages/send';
    var redirect = '../../messages/';
    var receiverId = "<?php echo $this->params['pass'][0] ?>";
    var page = 'conversation';
</script>

<?php
    echo $this->Form->create('Message');
    echo $this->Form->input('content', array('id' => 'message'));
    echo $this->Form->button('Reply Message', array(
        'id' => 'send-btn'
    ));
    echo $this->Form->end();
    echo '<br><br>';
    echo $this->Form->input(FALSE, array(
        'id' => 'search',
        'placeholder' => 'Search convo here...'
    ));
?>
<a href="#" id="show-more">Show More</a>

