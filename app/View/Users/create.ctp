<h1>Create Account</h1>
<?php
    echo $this->Html->script(array(
        'jquery', 
        'registration'
    ), FALSE);
    echo $this->Form->create('User');
    echo $this->Form->input('name');
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('confirm-password', array(
        'type' => 'password',
        'label' => 'Confirm Password'
    ));
    echo $this->Form->end('Create account');
    echo $this->Form->postLink('Go back to LOGIN', array('action' => 'login'));

?>