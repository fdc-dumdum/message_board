<?php 
    echo $this->Html->script(array(
        'jquery',
        'sendMessage', 
        'select2.min'), FALSE);

        if($messages[0]['messages']['from_id'] == AuthComponent::user('id')){
            $sendTo = $messages[0]['messages']['to_id'];
        } 
        else{
            $sendTo = $messages[0]['messages']['from_id'];
        }
?>


<script>
    var url = '../../messages/send';
    var redirect = '../../messages/';
    var receiverId = "  <?php echo $sendTo ?>";
    var page = 'conversation';
</script>
<div id="success"></div>
<h2>Recipient: <?php echo $messages[0]['users']['name'] ?></h2>
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
    
    foreach($messages as $message) :
        if($message['messages']['from_id'] == AuthComponent::user('id')){
            echo '
                <div class="container darker">
                    '.$this->Html->image('unknown.jpeg', array(
                        'class' => 'right'
                    )).'
                    <p class="float-right">'.$message['messages']['content'].'</p>
                    <span class="time-right">'.$message['messages']['created'].' - (you)</span>
                </div>
            ';
        }
        else{
            echo '
                <div class="container">
                    '.$this->Html->image('unknown.jpeg').'
                    <p>'.$message['messages']['content'].'</p>
                    <span>'.$message['messages']['created'].'
                </div>
            ';
        }
    endforeach;

?>
<br>
<a href="#" id="show-more">Show More</a>
<div id="sending" style="display: none; background-color: lightgreen">Sending...</div>

