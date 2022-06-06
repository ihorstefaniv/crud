<?php 
namespace app\controllers;

use core\RestController;
use core\Model;

class UserRestController extends RestController {

    public function userCreateAction(){


        $errors = null;
        if(!isset($_POST['first-name']) || empty($_POST['first-name'])) {
            $errors[] = ['code' => 100, 'message' => "Field first name is empty"]; 
        }

        
        if(!isset($_POST['last-name']) || empty($_POST['last-name'])) {
            $errors[] = ['code' => 100, 'message' => "Field last name is empty"];
        }

        if(!isset($_POST['status']) || empty($_POST['status'])) {
            $errors[] = ['code' => 100, 'message' => "Field status is not set"];
        }
       

        if(!isset($_POST['role']) || empty($_POST['role'])) {
            $errors[] = ['code' => 100, 'message' => "Field last role is not set"]; 
        }

        if($errors) {

            $status = false;
            $error = $errors;

            $this-> set(compact('status', 'error'));
           return;
        }
        else {
            $dataUser = ['first_name' => $_POST['first-name'],
            'last_name' => $_POST['last-name'],
            'status' => $_POST['status'],
            'role' => $_POST['role']];
            
                $user  = new Model();
                $user = $user->create($dataUser);
                
                if($user['status'] == true) {
                    $message = "create user success";
                    $status = true;
                    $dataUser['id'] = $user['id'];
                    $user =  $dataUser;

                    $this->set(compact('message', 'status', 'user'));
                }
                else {
                    $status = false;
                    $error = $status;
                    $this-> set(compact('status', 'error'));
                }
        }  
    
    }

    public function userGetAction() {

        if(!isset($_GET['id'])){
            $status = false;
            $error = ['code'=> 404, 'message' => 'Not id user'];
            $this-> set(compact('status', 'error')); 
        }

        $userId = $_GET['id'];
        $user  = new Model();
        $user =$user->getOne($userId);

      //  var_dump($user);

        if(!isset($user[0]['id'])) {
            $status = false;
            $error = ['code'=> 404, 'message' => 'User not found'];
            $this-> set(compact('status', 'error')); 
        }
        else 
        {
            $status = true;
            $error = '';
            $this-> set(compact('status', 'user')); 
        }
    }


    public function userUpdateAction()
    {
        $userId = $_POST['id'];
        $dataUser = [
            'id' => $_POST['id'],
            'first_name' => $_POST['first-name'],
        'last_name' => $_POST['last-name'],
        'status' => $_POST['status'],
        'role' => $_POST['role']];
        
            $user  = new Model();
            $status = $user->update($userId ,$dataUser);
            
            if($status == true) {
                $message = "update user success";
                $status = true;
                $user =  $dataUser;
    
                $this->set(compact('status', 'message',  'user'));
            }
            else {
                $status = false;
                $error = $status;
                $this-> set(compact('status', 'error'));
            }


    }

    public function userDeleteAction() {
        $userId = $_POST['id'];
        $user = new Model();

        $currentUser = $user->getOne($userId);

       if(!isset($currentUser[0]['id']))
       {
        $status = false;
        $error = ['code'=> 404, 'message' => 'User not found'];
        $this-> set(compact('status', 'error'));
       }
    else {
        $user->delete($userId);
        $message = "Delete user success";
        $status = true;
        $this->set(compact('status', 'message'));
    }
         
    }

    public function userSetActiveAction(){
        $user = new Model();
        $id = $_POST['id'];
        $user->setActive($id);
        $user = $user->getOne($id);
        $status = true;
        $message = 'Update success';
        $this-> set(compact('status', 'user' , 'message'));
    }

    public function userUnActiveAction(){
        $user = new Model();
        $id = $_POST['id'];
        $user->setUnActive($id);
        $user = $user->getOne($id);
        $status = true;
        $message = 'Update success';
        $this-> set(compact('status', 'user', 'message'));
    }

}