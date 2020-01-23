<?php

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