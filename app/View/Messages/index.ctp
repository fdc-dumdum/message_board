<?php echo $this->Html->script('jquery', FALSE); ?>
<h2>People you can contact</h2>
<?php

    echo $this->Html->link($this->Form->button('New Message'), array(
        'action' => 'new'
    ), array(
        'escape'=>false
    ));
    foreach($users as $user) :
        echo '
            <div class="container">
                '.$this->Html->image('unknown.jpeg', array('alt' => $user['User']['name'], 'border' => '0')).'
                '.$this->Form->postLink($user['User']['name'], array(
                    'action' => 'send', $user['User']['id']
                )).'
                <br>
                <br>
                '.$this->Form->postLink('Delete', array(
                    'value' => $user['User']['id'],
                    'class' => 'delete'
                )).'
            </div>
        ';
    endforeach;

?>