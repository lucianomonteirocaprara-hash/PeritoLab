<?php
declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('VIEWS_PATH', APP_PATH . '/Views');
define('TMP_PATH', BASE_PATH . '/tmp');

require_once BASE_PATH . '/core/Router.php';
require_once BASE_PATH . '/core/Controller.php';

spl_autoload_register(function (string $class): void {
    $file = APP_PATH . '/Controllers/' . $class . '.php';

    if (file_exists($file)) {
        require_once $file;
    }
});

$router = new Router();

$router->get('/',           'HomeController',      'index');
$router->get('/hash',       'HashController',      'index');
$router->post('/hash',      'HashController',      'process');
$router->get('/integrity',  'IntegrityController', 'index');
$router->post('/integrity', 'IntegrityController', 'process');
$router->get('/custody',    'CustodyController',   'index');
$router->post('/custody',   'CustodyController',   'process');
$router->get('/metadata',   'MetadataController',  'index');
$router->post('/metadata',  'MetadataController',  'process');

$router->dispatch();
