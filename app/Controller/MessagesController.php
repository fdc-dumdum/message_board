<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $people = $this->Message->query("SELECT users.id, users.name 
            FROM users, messages 
            WHERE to_id=users.id AND (from_id='".$this->Auth->user('id')."' OR to_id='".$this->Auth->user('id')."')
            GROUP BY to_id
            ORDER BY messages.created DESC");

            $this->set('users', $people);
        }

        public function delete() {
            if($this->request->is('ajax')){
                $response = $this->Message->deleteAll(array('Message.to_id' => $this->request->data['id']));
                
                if($response){
                    echo 'Deleted';
                }
                else{
                    echo 'Something went wrong';
                }
                exit();
            }
        }

        public function conversation($id) {
            $messages = $this->Message->find('all', array(
                'OR' => array(
                    'Message.from_id' => $this->Auth->user('id'),
                    'Message.to_id' => $this->Auth->user('id')
                ),
                'order' => array(
                    'created' => 'desc'
                ),
                'group' => 'Message.from_id',
                'limit' => 5,
                'offset' => 0
            ));

            // echo '<pre>';
            // print_r($messages);
            // echo '</pre>';

            $this->set('messages', $messages);
        }

        public function send() {

            $this->request->trustProxy = true;
            $clientIp = $this->request-> clientIp();

            // $messages = $this->Message->find('all', array(
            //     'OR' => array(
            //         'Message.from_id' => $this->Auth->user('id'),
            //         'Message.to_id' => 1
            //     ),
            //     'order' => array(
            //         'created' => 'asc'
            //     ),
            //     'limit' => 10,
            //     'offset' => 0
            // ));

            // if(!empty($this->data)) {
                // $this->Message->set(array(
                //     'to_id' => 2,
                //     'from_id' => $this->Auth->user('id'),
                //     'created_ip' => $clientIp,
                //     'modified_ip' => $clientIp
                // ));

                if($this->request->is('ajax')){
                    $this->request->data['Message']['to_id'] = $this->request->data['id'];
                    $this->request->data['Message']['from_id'] = $this->Auth->user('id');
                    $this->request->data['Message']['content'] = $this->request->data['message'];
                    $this->request->data['Message']['created_ip'] = $this->request->data['Message']['modified_ip'] = $this->request-> clientIp();

                    $this->Message->set($this->request->data);

                    $response = $this->Message->save();

                    if($response){
                        echo 'Message sent';
                    }
                    else{
                        echo 'Something went wrong';
                    }
                    exit();
                }

                // if($this->request->isPost()){
                    
                //     echo $this->request->data['id'];
                //     // if($this->Message->save($this->data)) {
                //     //     $this->render('success', 'ajax');
                //     // }
                // }
                
                // if($this->RequestHandler->isAjax()){
                //     if($this->Message->save($this->data)) {
                //         $this->render('success', 'ajax');
                //     }
                //     else {
                //         $this->Session->setFlash('Sending message failed');
                //     }
                // }
                // else{
                //     // $this->redirect('send')->set('messages', $messages);
                //     // $this->Session->setFlash('Message sent.');
                // }
            // }
            // else{
            //     $this->set('messages', $messages);
            // }
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
        }

    }

?>