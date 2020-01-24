<?php 
    echo $this->Html->script(array(
            'jquery', 
            'messageIndex',
        ), FALSE); 
?>

<?php
    echo $this->Html->link($this->Form->button('Compose New MEssage'), array(
        'controller' => 'messages',
        'action' => 'compose'
    ), array(
        'escape'=>false
    ));
    echo '<br><br>';

    if(count($users) > 0){
        foreach($users as $user) :
            echo $this->Form->create('Message');
            echo '<div class="container ">';
            if($user['users']['image'] == null){
                echo $this->Html->image('unknown.jpeg', array(
                    'alt' => $user['users']['name'], 
                ));
            }
            else{
                echo $this->Html->image($user['users']['image'], array(
                    'alt' => $user['users']['name'],
                    'width' => 40
                ));
            }
            echo $this->Html->link($user['users']['name'], array(
                'controller' => 'messages',
                'action' => 'conversation', $user['users']['id']
            ));
            echo ' - ';
            echo $this->Html->link('Profile', array(
                'controller' => 'users',
                'action' => 'profile', $user['users']['id']
            ), array('target' => '_blank'));
            echo '<br>';
            echo '<br>';
            echo '<span class="mtop content">'.$user['messages']['content'].'</span>';
            echo '<br>';
            echo '<a href="#" class="fright delete" value="'.$user['users']['id'].'">DELETE</a>';
            echo '</div>';
        endforeach;
    }
    else{
        echo '
            <div class="container">You have no connections with people yet</div>
        ';
    }
?>