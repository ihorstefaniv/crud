<?php

use core\Router;


Router::addRest('^create-user', ['controller' => 'UserRest', 'action' => 'userCreate']);
Router::addRest('^get-user', ['controller' => 'UserRest', 'action' => 'userGet']);
Router::addRest('^delete-user', ['controller' => 'UserRest', 'action' => 'userDelete']);
Router::addRest('^update-user', ['controller' => 'UserRest', 'action' => 'userUpdate']);
Router::addRest('^user-group-action', ['controller' => 'UserRest', 'action' => 'userGroup']);

Router::addRest('^setactive-user', ['controller' => 'UserRest', 'action' => 'userSetActive']);
Router::addRest('^setunactive-user', ['controller' => 'UserRest', 'action' => 'userUnActive']);

Router::add('^$', ['controller' => 'Main', 'action' => 'index']);
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
