<?php 
    echo $this->Html->script(array(
            'jquery', 
            'messageIndex',
            'readmore'
        ), FALSE); 
?>
<?php

    echo $this->Html->link($this->Form->button('Compose New MEssage'), array(
        'action' => 'new'
    ), array(
        'escape'=>false
    ));
    echo '<br><br>';
    echo '<br><br>';

    if(count($users) > 0){
        foreach($users as $user) :
            echo $this->Form->create('Message');
            echo '<div class="container shett" id="conversations">';
            echo $this->Html->image('unknown.jpeg', array('alt' => $user['users']['name'], 'border' => '0'));
            echo $this->Html->link($user['users']['name'], array(
                'controller' => 'messages',
                'action' => 'conversation', $user['users']['id']
            ));
            echo ' - ';
            echo $this->Html->link('Profile', array(
                'controller' => 'users',
                'action' => 'profile', $user['users']['id']
            ), array('target' => '_blank'));
            echo '<br><br>';
            echo '<div id="readMoreReadLess">';
            echo '<span class="slide">'.$user['messages']['content'].'</span>';
            echo '</div>';
            echo '<br><br>';
            echo $this->Form->button('Delete', array(
                'value' => $user['users']['id'],
                'class' => 'delete',
                'type' => 'button'
            ));
            echo '</div>';
        endforeach;
    }
    else{
        echo '
            <div class="container">You have no connections with people yet</div>
        ';
    }

?>