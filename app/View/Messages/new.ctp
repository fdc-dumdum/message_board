<?php 
    echo $this->Html->script('jquery', FALSE);
    echo $this->Html->script('validation', FALSE); 
    echo $this->Html->script('new', FALSE); 
?>
<div id="success"></div>
<h2>New Message</h2>

<select class="js-example-basic-multiple" style="width: 200px" id="users">
    <?php
        foreach($users as $user) :
            echo '<option value="'.$user['User']['id'].'">'.$user['User']['name'].'</option>';
        endforeach;
    ?>
</select>
<?php
    echo $this->Form->create();
    echo $this->Form->input('content', array('id' => 'content'));
    echo $this->Js->submit('Send', array(
        'before' => $this->Js->get('#sending')->effect('fadeIn'),
        'success' => $this->Js->get('#sending')->effect('fadeOut'),
        'update' => '#success',
        'url' => 'send'
    ));
    echo $this->Form->end();
?>
<div id="sending" style="display: none; background-color: lightgreen">Sending...</div>
