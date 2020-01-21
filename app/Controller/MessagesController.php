<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $user = new User();
            $users = $user->find('all');
            $this->set('users', $users);
        }

        public function send() {

            $this->request->trustProxy = true;
            $clientIp = $this->request-> clientIp();

            $messages = $this->Message->find('all', array(
                'OR' => array(
                    'Message.from_id' => $this->Auth->user('id'),
                    'Message.to_id' => 1
                ),
                'order' => array(
                    'created' => 'asc'
                ),
                'limit' => 10,
                'offset' => 0
            ));

            if(!empty($this->data)) {
                $this->Message->set(array(
                    'to_id' => 2,
                    'from_id' => $this->Auth->user('id'),
                    'created_ip' => $clientIp,
                    'modified_ip' => $clientIp
                ));

                if($this->Message->save($this->data)) {
                    if($this->RequestHandler->isAjax()){
                        $this->render('success', 'ajax');
                    }
                    else{
                        // $this->redirect('send')->set('messages', $messages);
                        // $this->Session->setFlash('Message sent.');
                    }
                }
                else {
                    $this->Session->setFlash('Sending message failed');
                }
            }
            else{
                $this->set('messages', $messages);
            }
        }

        public function new(){
            $user = new User();
            $users = $user->find('all', array(
                'conditions' => array(
                    'User.id !=' => $this->Auth->user('id')
                ),
                'fields' => array(
                    'User.id', 'User.name'
                )
            ));
            $this->set('users', $users);
            // echo '<pre>';
            // print_r($users);
            // echo '</pre>';
        }

    }

?>