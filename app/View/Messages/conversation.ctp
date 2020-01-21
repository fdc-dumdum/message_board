<script>
    var url = '../messages/send';
</script>

<?php 
    echo $this->Html->script(array(
        'jquery', 'sendMessage', 'select2.min'), FALSE);
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
        if($message['Message']['from_id'] == AuthComponent::user('id')){
            echo '
                <div class="container darker">
                    '.$this->Html->image('unknown.jpeg', array(
                        'class' => 'right'
                    )).'
                    <p class="float-right">'.$message['Message']['content'].'</p>
                    <span class="time-right">'.$message['Message']['created'].' - (you)</span>
                </div>
            ';
        }
        else{
            echo '
                <div class="container">
                    '.$this->Html->image('unknown.jpeg').'
                    <p>'.$message['Message']['content'].'</p>
                    <span>'.$message['Message']['created'].' -
                    '.$this->Form->postLink('Delete').'</span>
                </div>
            ';
        }
    endforeach;

?>
<br>
<a href="#" id="show-more">Show More</a>
<div id="sending" style="display: none; background-color: lightgreen">Sending...</div>