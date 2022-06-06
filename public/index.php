<?php

require_once '../vendor/autoload.php';

require_once dirname(__DIR__) . '/config/config_db.php';

require_once dirname(__DIR__) . '/config/init.php';


require_once dirname(__DIR__) . '/config/routes.php';

new core\App();