<?php 
    echo $this->Html->script(array(
        'jquery',
        'jquery-ui-1.12.1' => array(
            'jquery-ui.min'
        ),
        'editProfile'
    ), FALSE); 

    echo $this->Html->css(array(
        'jquery-ui.min.css',
        'images'
    ));
?>

<h1>Upload File</h1>

<div class="content">
    <div>
        <?php 
            foreach($details as $detail){
                echo $this->Form->create('User', [
                    'type' => 'file', 
                    'url' => 'update', 
                    'controller' => 'users'
                ]); 
                if($detail['image'] == null){
                    echo $this->Html->image('unknown.jpeg', [
                        'height' => '300',
                        'alt' => 'unknown',
                        'id' => 'image-viewer'
                    ]);
                }
                else{
                    echo $this->Html->image($detail['image'], [
                        'height' => '300',
                        'alt' => $detail['image'],
                        'id' => 'image-viewer'
                    ]);
                }
                echo $this->Form->input('file', [
                    'type' => 'file', 
                    'accept' => '.jpg, .png, .gif'
                    ]);
                echo $this->Form->input('email', ['value' => $detail['email']]);
                echo $this->Form->input('password', array(
                    'type' => 'password',
                    'id' => 'password',
                    'placeholder' => 'Enter current password and hit enter',
                    'required' => false
                ));
                echo $this->Form->input('name', ['value' => $detail['name']]);

                $options = [
                    'M' => 'Male', 
                    'F' => 'Female'
                ];

                if($detail['gender'] == null){
                    $attributes = ['default' => 'M'];
                }
                else{
                    if($detail['gender'] == 1){
                        $attributes = ['default' => 'M'];
                    }
                    else{
                        $attributes = ['default' => 'F'];
                    }
                }

                echo $this->Form->radio('gender', $options, $attributes);

                if($detail['birthdate'] == null){
                    echo $this->Form->input('birthdate', [
                        'type' => 'text',
                        'id' => 'birthdate'
                    ]);
                }
                else{
                    echo $this->Form->input('birthdate', [
                        'type' => 'text',
                        'id' => 'birthdate',
                        'value' => $detail['birthdate']
                    ]);
                }
                echo $this->Form->input('hubby', ['value' => $detail['hubby']]);
                echo $this->Form->button('Save Changes', [
                    'type' => 'submit'
                ]); 
                echo $this->Form->end();
            }
        ?>
    </div>