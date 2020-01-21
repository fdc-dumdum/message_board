<?php

    class UsersController extends AppController {

        public $userIp;
        public $isEmailExist;

        // Access to pages even that dont require login
        public function beforeFilter() {
            $this->userIp = $this->request->clientIp();
            $this->Auth->allow(array('create'));
            
            // Check if already logged in
            if (in_array($this->request->action, ['login', 'create']) && !empty($this->Auth->user('id'))) {
                $this->Session->setFlash('Permission denied! You are already logged in');
                $this->redirect($this->Auth->loginRedirect);
            }
        }

        public function create() {
            if(!empty($this->data)) {
                $this->isEmailExist = array(
                    'User.email' => $this->request->data['User']['email']
                );

                if(strlen($this->request->data['User']['name']) <= 4 || strlen($this->request->data['User']['name']) > 20){
                    return $this->Flash->error('Name should be at least 5 - 20 characters long');
                }
                else if($this->request->data['User']['password'] != $this->request->data['User']['confirm-password']){
                    return $this->Flash->error('Password does not match');
                }
                else if($this->User->hasAny($this->isEmailExist)){
                    return $this->Flash->error('Email already exist.');
                }
                else{
                    $this->User->set(array(
                        'created_ip' => $this->userIp,
                        'modified_ip' => $this->userIp
                    ));
                    
                    $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
    
                    if($this->User->save($this->data)) {

                        $user = $this->User->findById($this->User->getLastInsertID());
                        $user = $user['User'];
                        $this->Auth->login($user);
                        // $this->Flash->success('Registration successful. You can login using your registered account.');
                        return $this->redirect('thankyou');
                    }
                    else {
                        return $this->Session->setFlash('Registration unsuccessful. Please try again!');
                    }
                }
            }
        }

        public function login(){
            if($this->request->is('post')){
                if(!empty($this->request->data)){
                    // AuthComponent predefined login
                    if($this->Auth->login(array())){
    
                        $this->User->id = $this->Auth->user('id');
                        $this->User->saveField('last_login_time', date('Y-m-d H:i:s'));
                        $this->User->saveField('modified_ip', $this->userIp);
    
                        return $this->redirect($this->Auth->loginRedirect);
                    }
                    else{
                        $this->Flash->error('Invalid username or password');
                    }
                }
            }
        }

        public function logout() {
            $this->redirect($this->Auth->logout());
        }

        public function profile($id) {
            $this->set('details', $this->User->findById($id));
        }

        public function edit($id) {
            $this->set('details', $this->User->findById($id));
        }

        public function thankyou() {
            $this->set('page', 'thankyou');
        }

        public function update() {
            if ($this->request->is('post')) {
                echo '<pre>';
                print_r($this->request->data);
                echo '</pre>';
                if(!empty($this->request->data['User']['file']['name'])){
                    $newEmail = array(
                        'User.id' => $this->Auth->user('id'),
                        'User.email !=' => $this->request->data['User']['email']
                    );
                    $filename = $this->request->data['User']['file']['name'];
                    $filepath = $_SERVER['DOCUMENT_ROOT'] . '/messenger/app/webroot/img/' . $this->request->data['User']['file']['name'];

                    if(empty($this->request->data['User']['email']) 
                    || empty($this->request->data['User']['name'])
                    || empty($this->request->data['User']['file']['name'])
                    || empty($this->request->data['User']['hubby'])){
                        $this->Flash->error('All fields are required');
                        $this->redirect($this->referer());
                    }
                    else if(strlen($this->request->data['User']['name']) <= 4){
                        $this->Flash->error('Name should be at least 5 - 20 characters long');
                    }
                    else{

                        if(move_uploaded_file($this->request->data['User']['file']['tmp_name'], $filepath)){
                            $this->User->id = $this->Auth->user('id');
                            $this->User->saveField('image', $filename);
                            $this->User->saveField('name', $this->request->data['User']['name']);
                            
                            if($this->User->hasAny($newEmail)){
                                if($this->User->hasAny($this->isEmailExist)){
                                    $this->Flash->error('Email already exist');
                                    $this->redirect($this->referer());
                                }
                                else{
                                    $this->User->saveField('email', $this->request->data['User']['email']);
                                }
                            }

                            if($this->request->data['User']['gender'] == 'M'){
                                $this->User->saveField('gender', 1);
                            }
                            else{
                                $this->User->saveField('gender', 2);
                            }

                            $this->User->saveField('hubby', $this->request->data['User']['hubby']);

                            // $this->redirect(array(
                            //     'controller' => 'users',
                            //     'action' => 'profile', $this->Auth->user('id')
                            // ));

                            $this->Flash->success('Upload file successful');
                        }
                        else{
                            $this->Flash->error('Unable to upload file, please try again.');
                        }
                    }
                }
                else{
                    $this->Flash->error('Please choose a file to upload.');
                    $this->redirect($this->referer());
                }
                
            }
        }
    }

?>