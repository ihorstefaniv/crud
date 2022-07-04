<?php

namespace app\controllers;

use core\Controller;
use core\Model;

class MainController extends Controller
{
    public function indexAction()
    {
      $users = new Model();

      $listUsers = $users->getAll();


      $this->set(compact('listUsers'));
      $this->setMeta('Users', '', '');
    }
}