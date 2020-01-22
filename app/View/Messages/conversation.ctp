<script>
    var url = '../../messages/send';
    var redirect = '../../messages/';
</script>

<?php 
    echo $this->Html->script(array(
        'jquery', 'messageIndex','sendMessage', 'select2.min'), FALSE);
?>
<div id="success"></div>
<h2>Message List</h2>
<?php
    
    echo $this->Form->create('Message');
    echo $this->Form->input('content', array('id' => 'message'));
    echo $this->Form->button('Reply Message', array(
        // 'before' => $this->Js->get('#sending')->effect('fadeIn'),
        // 'success' => $this->Js->get('#sending')->effect('fadeOut'),
        // 'update' => '#success',
        // 'url' => 'send',
        'id' => 'send-btn'
    ));
    // echo $this->Form->input('content', array('id' => 'content'));
    // echo $this->Js->submit('Send', array(
    //     'before' => $this->Js->get('#sending')->effect('fadeIn'),
    //     'success' => $this->Js->get('#sending')->effect('fadeOut'),
    //     'update' => '#success'
    // ));
    echo $this->Form->end();
    
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
