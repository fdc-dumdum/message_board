<?php

    App::uses('User', 'Model');

    class MessagesController extends AppController {

        public function index() {
            $sql = "SELECT content, name, users.id, image 
                    FROM (
                        SELECT MAX(m1.created) AS latest, u1.id 
                        FROM messages m1, users u1 
                        WHERE (((from_id!='".$this->Auth->user('id')."' 
                            AND to_id='".$this->Auth->user('id')."') 
                            AND from_id=u1.id)
                        OR ((from_id='".$this->Auth->user('id')."' 
                            AND to_id!='".$this->Auth->user('id')."') 
                            AND to_id=u1.id)) 
                        AND (from_id='".$this->Auth->user('id')."' 
                            OR to_id='".$this->Auth->user('id')."') 
                        GROUP BY u1.id
                        ) result, 
                    messages, users 
                    WHERE messages.created=latest AND users.id=result.id 
                    ORDER BY latest DESC";

            $this->set('users', $this->Message->query($sql));
        }

        public function delete() {
            if($this->request->is('ajax')){
                $sql = "DELETE FROM messages 
                        WHERE (from_id='".$this->Auth->user('id')."' 
                        AND to_id='".$this->request->data['id']."')
                        OR (to_id='".$this->Auth->user('id')."' 
                        AND from_id='".$this->request->data['id']."')";
                
                $response = $this->Message->query($sql);
                
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
            if($this->request->is('ajax')){
                $sql = "SELECT content, messages.created, from_id, image, 
                            (
                                SELECT image 
                                FROM users 
                                WHERE id=".$this->Auth->user('id')."
                            ) AS user_image
                        FROM messages, users 
                        WHERE (from_id=".$this->Auth->user('id')." AND to_id=".$this->request->data['id']." AND to_id=users.id) 
                        OR (from_id=".$this->request->data['id']." AND to_id=".$this->Auth->user('id')." AND from_id=users.id)
                        ORDER BY created DESC LIMIT 10 OFFSET ".$this->request->data['offset']."";

                $messages = $this->Message->query($sql);

                $this->set('messages', $messages); 
                $this->render('content');
            }
        }
        
        public function search(){
            if($this->request->is('ajax')){
                if(empty($this->request->data['keyword'])){
                    $sql = "SELECT name, content, messages.created, from_id, to_id  , image,
                            (
                                SELECT image 
                                FROM users 
                                WHERE id=".$this->Auth->user('id')."
                            ) AS user_image 
                            FROM messages, users
                            WHERE (from_id=".$this->Auth->user('id')." AND to_id=".$this->request->data['id']." AND to_id=users.id) 
                                OR (from_id=".$this->request->data['id']." AND to_id=".$this->Auth->user('id')." AND from_id=users.id)
                            ORDER BY messages.created DESC LIMIT 10 OFFSET 0";

                    $messages = $this->Message->query($sql);
                }
                else{
                    $sql = "SELECT name, content, messages.created, from_id, to_id, image,
                            (
                                SELECT image 
                                FROM users 
                                WHERE id=".$this->Auth->user('id')."
                            ) AS user_image 
                            FROM messages, users
                            WHERE ((from_id=".$this->Auth->user('id')." AND to_id=".$this->request->data['id']." AND to_id=users.id) 
                                OR (from_id=".$this->request->data['id']." AND to_id=".$this->Auth->user('id')." AND from_id=users.id))
                                AND content LIKE '%".$this->request->data['keyword']."%'
                            ORDER BY messages.created DESC LIMIT 10 OFFSET 0";
                    
                    $messages = $this->Message->query($sql);
                }
                
                $this->set('messages', $messages); 
                $this->render();
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

        public function compose(){
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