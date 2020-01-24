<?php
    echo $this->Html->script(array(
        'jquery',
        'sendMessage'
    ), FALSE);


    foreach($messages as $message) :
        if($message['messages']['from_id'] == AuthComponent::user('id')){
            echo '<div class="container darker">';
            if($message['users']['image'] == null){
                echo $this->Html->image('unknown.jpeg', array(
                        'class' => 'right',
                        'width' => 40
                    ));
            }
            else{
                echo $this->Html->image($message[0]['user_image'], array(
                    'class' => 'right',
                    'width' => 40
                ));
            }
            echo '<p class="float-right">'.$message['messages']['content'].'</p>';
            echo '<span class="time-right">'.$message['messages']['created'].' - (you)</span>';        
            echo '</div>';
        }
        else{
            echo '<div class="container">';
            if($message['users']['image'] == null){
                echo $this->Html->image('unknown.jpeg', array(
                    'width' => 40
                ));
            }
            else{
                echo $this->Html->image($message['users']['image'], array(
                    'width' => 40
                ));
            }
            echo '<p>'.$message['messages']['content'].'</p>';
            echo '<span>'.$message['messages']['created'].'';
            echo '</div>';
        }
    endforeach;
?>