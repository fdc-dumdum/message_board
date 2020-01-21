<?php 
    echo $this->Html->script('jquery', FALSE);
    echo $this->Html->script('validation', FALSE); 
?>
<div id="success"></div>
<h2>Message List</h2>
<?php
    
    echo $this->Form->create();
    echo $this->Form->input('content', array('id' => 'content'));
    echo $this->Js->submit('Send', array(
        'before' => $this->Js->get('#sending')->effect('fadeIn'),
        'success' => $this->Js->get('#sending')->effect('fadeOut'),
        'update' => '#success'
    ));
    echo $this->Form->end();
    
    foreach($messages as $message) :
        if($message['Message']['from_id'] == 1){
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

<div id="sending" style="display: none; background-color: lightgreen">Sending...</div>