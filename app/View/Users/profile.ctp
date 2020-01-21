<?php
    echo $this->Flash->render();
    foreach($details as $detail){
        echo '
            <div class="card">
                <h1 class="header">User Profile</h1>
        ';

        if($detail['image'] != null){
            echo $this->Html->image($detail['image'], array(
                'height' => '300'
            ));
        }
        else{
            echo $this->Html->image('unknown.jpeg', array(
                'height' => '300'
            ));
        }

        echo '
                <p class="title"><br>'.$detail['name'].'</p>
                <h1 class="header">Personal Details</h1>
        ';
                if($detail['gender'] == 1){
                    echo '<p>Gender: Male</p>';
                }
                else if($detail['gender'] == 2){
                    echo '<p>Gender: Female</p>';
                }
                else{
                    echo '<p>Gender: NOT SPECIFIED</p>';
                }

                if($detail['birthdate'] == null){
                    echo '<p>Birthdate: NOT SPECIFIED</p>';
                }
                else{
                    echo '<p>Birthdate: '.date("M d, Y", strtotime($detail['birthdate'])).'</p>';
                }
        echo '
                <p>Joined: '.date("M d, Y h A", strtotime($detail['created'])).'</p>
                <p>Last Login: '.date("M d, Y h A", strtotime($detail['last_login_time'])).'</p>
                <h1 class="header">Hubby</h1>
        ';
                if($detail['hubby'] == null){
                    echo '<p>NO HUBBY STATED</p>';
                }
                else{
                    echo '<p>'.$detail['hubby'].'</p>';
                }
        echo '
                <p>'.$this->Form->postLink('EDIT INFORMATION', array(
                    'controller' => 'users',
                    'action' => 'edit', AuthComponent::user('id')
                )).'</p>
                <br>
            </div>
        ';
    }
?>