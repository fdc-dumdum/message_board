<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $people = $this->Message->query("SELECT users.id, users.name, content
                FROM users, messages 
                WHERE (((from_id!='".$this->Auth->user('id')."' AND to_id='".$this->Auth->user('id')."') AND from_id=users.id) 
                OR ((from_id='".$this->Auth->user('id')."' AND to_id!='".$this->Auth->user('id')."') AND to_id=users.id))
                AND (from_id='".$this->Auth->user('id')."' OR to_id='".$this->Auth->user('id')."')
                GROUP BY users.id
                ORDER BY MAX(messages.created) DESC
            ");

// SELECT users.id, users.name, (SELECT content FROM messages WHERE ) FROM users, messages WHERE (((from_id!=1 AND to_id=1) AND from_id=users.id) OR ((from_id=1 AND to_id!=1 AND to_id=users.id))) AND from_id=1 GROUP BY users.id
// ORDER BY MAX(messages.created) DESC

            // debug($people);

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
                die();
            }
        }

        public function conversation($id) {
            $messages = $this->Message->query("SELECT content, created, from_id 
                FROM messages 
                WHERE (from_id='".$this->Auth->user('id')."' AND to_id=$id) OR (from_id=$id AND to_id='".$this->Auth->user('id')."')
                ORDER BY created DESC LIMIT 5 OFFSET 0");
            
            $this->set('messages', $messages);
        }

        public function pagination(){
            $this->autoRender = false;
            if($this->request->is('ajax')){
                $messages = $this->Message->query("SELECT content, created, from_id 
                FROM messages 
                WHERE (from_id=1 AND to_id=1) OR (from_id=1 AND to_id=1)
                ORDER BY created DESC LIMIT 5 OFFSET 0");
            
                debug($messages);
                return;

                $this->layout = "ajax";
                $this->set('messages', $messages);
            }
        }

        public function send() {
            $this->request->trustProxy = true;
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
