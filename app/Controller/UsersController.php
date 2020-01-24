<?php

    class UsersController extends AppController {

        public $userIp;
        public $isEmailExist;

        public function beforeFilter() {
            $this->userIp = $this->request->clientIp();

            // Access to pages that dont require login
            $this->Auth->allow(array('create'));
            
            // Check if already logged in
            if (in_array($this->request->action, ['login', 'create']) && !empty($this->Auth->user('id'))) {
                $this->Session->setFlash('Permission denied! You are already logged in');
                $this->redirect($this->Auth->loginRedirect);
            }
        }

        public function create() {
            if(!empty($this->data)) {
                $this->isEmailExist = array('User.email' => $this->request->data['User']['email']);

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
                    $this->request->data['User']['last_login_time'] = date('Y-m-d H:i:s');
                    $this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
                    $this->request->data['User']['modified_ip'] = $this->request->data['User']['created_ip'] = $this->userIp;

                    $this->User->set($this->request->data);

                    $response = $this->User->save();

                    if($response){
                        $user = $this->User->findById($response['User']['id']);

                        $this->Auth->login($user['User']);

                        return $this->redirect('thankyou');
                    }
                    else {
                        return $this->Session->setFlash('Registration unsuccessful. Please try again!');
                    }
                }
            }
        }

        public function login(){
            if(!empty($this->request->data)){
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

        public function checkPassword() {
            if($this->request->is('ajax')){
                $condition = array(
                    'User.id' => $this->Auth->user('id'),
                    'User.password' => AuthComponent::password($this->request->data['password'])
                );
                
                $response = $this->User->hasAny($condition);

                if($response)
                    echo 1;
                else
                    echo 0;

                $this->render(false);
            }
        }

        public function update() {
            if(empty($this->request->data['User']['email']) 
            || empty($this->request->data['User']['name'])
            || empty($this->request->data['User']['file']['name'])
            || empty($this->request->data['User']['hubby'])){
                return $this->Flash->error('All fields are required');
            }
            else if(strlen($this->request->data['User']['name']) <= 4){
                return $this->Flash->error('Name should be at least 5 - 20 characters long');
            }
            else{
                $this->isEmailExist = array('User.email' => $this->request->data['User']['email']);
                $filename = $this->request->data['User']['file']['name'];
                $filepath = $_SERVER['DOCUMENT_ROOT'] . '/messenger/app/webroot/img/' . $this->request->data['User']['file']['name'];
                $changeCurrentEmail = array(
                    'User.id' => $this->Auth->user('id'),
                    'User.email !=' => $this->request->data['User']['email']
                );

                $currentPassword = array(
                    'User.id' => $this->Auth->user('id'),
                    'User.password' => AuthComponent::password($this->request->data['User']['password'])
                );
                    
                if($this->User->hasAny($changeCurrentEmail)){
                    if($this->User->hasAny($this->isEmailExist)){
                        $this->Flash->error('Email already exist');
                        $this->redirect($this->referer());
                    }
                    else{
                        $email = $this->request->data['User']['email'];
                    }
                }
                else{
                    $email = $this->Auth->user('email');
                }

                if($this->request->data['User']['gender'] == 'M'){
                    $gender = 1;
                }
                else{
                    $gender = 2;
                }

                if(move_uploaded_file($this->request->data['User']['file']['tmp_name'], $filepath)){
                    $this->User->id = $this->Auth->user('id');
                    $this->User->saveField('image', $filename);
                    $this->User->saveField('name', $this->request->data['User']['name']);
                    $this->User->saveField('email', $email);
                    $this->User->saveField('gender', $gender);
                    $this->User->saveField('birthdate', date("Y-m-d", strtotime($this->request->data['User']['birthdate'])));
                    $this->User->saveField('hubby', $this->request->data['User']['hubby']);

                    if($this->User->hasAny($currentPassword)){
                        $this->User->saveField('password', AuthComponent::password($this->request->data['User']['new-password']));
                    }

                    $this->redirect(array('action' => 'profile', $this->Auth->user('id')));
                }
                else{
                    $this->Flash->error('Unable to upload file, please try again.');
                }
            }
        }
    }

?>