<?php

namespace app\controllers;

use core\RestController;
use core\Model;

class UserRestController extends RestController
{

    public function userCreateAction()
    {


        $errors = null;
        if (!isset($_POST['first-name']) || empty($_POST['first-name'])) {
            $errors[] = ['code' => 100, 'message' => "Field first name is empty"];
        }


        if (!isset($_POST['last-name']) || empty($_POST['last-name'])) {
            $errors[] = ['code' => 100, 'message' => "Field last name is empty"];
        }

        if (!isset($_POST['status']) || empty($_POST['status'])) {
            $errors[] = ['code' => 100, 'message' => "Field status is not set"];
        }


        if (!isset($_POST['role']) || empty($_POST['role'])) {
            $errors[] = ['code' => 100, 'message' => "Field last role is not set"];
        }

        if ($errors) {

            $status = false;
            $error = $errors;

            $this->set(compact('status', 'error'));
            return;
        } else {
            $dataUser = [
                'first_name' => $_POST['first-name'],
                'last_name' => $_POST['last-name'],
                'status' => $_POST['status'],
                'role' => $_POST['role']
            ];

            $user  = new Model();
            $user = $user->create($dataUser);

            if ($user['status'] == true) {
                $error = null;
                $status = true;
                $dataUser['id'] = $user['id'];
                $user =  $dataUser;

                $this->set(compact('status', 'error', 'user'));
            } else {
                $status = false;
                $error = $status;
                $this->set(compact('status', 'error'));
            }
        }
    }

    public function userGetAction()
    {

        if (!isset($_GET['id'])) {
            $status = false;
            $error = ['code' => 404, 'message' => 'Not id user'];
            $this->set(compact('status', 'error'));
        }

        $userId = $_GET['id'];
        $user  = new Model();
        $user = $user->getOne($userId);

        if (!isset($user[0]['id'])) {
            $status = false;
            $error = ['code' => 404, 'message' => 'User not found'];
            $this->set(compact('status', 'error'));
        } else {
            $status = true;
            $error = null;
            $this->set(compact('status', 'error', 'user'));
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
            'role' => $_POST['role']
        ];

        $user  = new Model();
        $status = $user->update($userId, $dataUser);

        if ($status == true) {
            $status = true;
            $error = null;
            $user =  $dataUser;

            $this->set(compact('status', 'error',  'user'));
        } else {
            $status = false;
            $error = $status;
            $this->set(compact('status', 'error'));
        }
    }



    public function userGroupAction()
    {
        $trueAction = ['delete' => 1, 'active' => 1, 'unactive' => 1];
        $userIds = $_POST['id'] ?? [];
        $action =  $_POST['action'] ?? '';
        $message = '';
        if (!isset($trueAction[$action])) {
            $status = false;
            $error = ['code' => 100, 'message' => 'Select action'];
            $this->set(compact('status', 'error'));
        } else {
            if (empty($userIds)) {
                $status = false;
                $error = ['code' => 404, 'message' => 'User not select'];
                $this->set(compact('status', 'error'));
            } else {
                $user = new Model();
                $userData = [];
                foreach ($userIds as $userId) {
                    $currentUser = $user->getOne($userId);
                    if (!isset($currentUser[0]['id'])) {
                        $status = false;
                        $error = ['code' => 404, 'message' => 'User ' . $userId . ' not found'];
                        $this->set(compact('status', 'error'));
                        break;
                    } else {
                        if ($action == 'delete') {
                            $user->delete($userId);
                            $userData[$currentUser[0]['id']]['id'] = $currentUser[0]['id'];
                        } elseif ($action == 'active') {
                            $user->setActive($userId);
                            $userData[$currentUser[0]['id']] = $user->getOne($currentUser[0]['id'])[0];
                        } elseif ($action == 'unactive') {
                            $user->setUnActive($userId);
                            $userData[$currentUser[0]['id']] = $user->getOne($currentUser[0]['id'])[0];
                        }
                    }
                }
                $status = true;
                $user = $userData;
                $error = null;
                $this->set(compact('status', 'error', 'user'));
            }
        }
    }



    public function userDeleteAction()
    {
        $userId = $_POST['id'];
        $user = new Model();

        $currentUser = $user->getOne($userId);

        if (!isset($currentUser[0]['id'])) {
            $status = false;
            $error = ['code' => 404, 'message' => 'User not found'];
            $this->set(compact('status', 'error'));
        } else {
            $user->delete($userId);
            $error = null;
            $status = true;
            $id = $userId;
            $this->set(compact('status', 'error', 'id'));
        }
    }

    public function userSetActiveAction()
    {
        $user = new Model();
        $id = $_POST['id'];
        $user->setActive($id);
        $user = $user->getOne($id);
        $status = true;
        $error = null;
        $this->set(compact('status', 'error', 'user'));
    }

    public function userUnActiveAction()
    {
        $user = new Model();
        $id = $_POST['id'];
        $user->setUnActive($id);
        $user = $user->getOne($id);
        $status = true;
        $error = null;
        $this->set(compact('status', 'error', 'user'));
    }
}
