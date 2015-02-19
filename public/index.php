<?php
/**
 * Main Script
 *
 * The system starts through that file, which defines: Settings, Templates System,
 * Singletons (DB, Session Auth...), Middlewares (MonitorMiddleware, $needLogged, $needAdmin..), etc.
 *
 * @author Gustavo Novaes <gustavonovaes93@gmail.com>
 */

use \Slim\Slim;
use \Slim\Views\Blade;
use \Slim\Log;

use \Illuminate\Database\Capsule\Manager;

use \SlimBase\AppLog;
use \SlimBase\Session;
use \SlimBase\Auth;
use \SlimBase\MonitorMiddleware;

//*
define('MODE',   'development');
/*/
define('MODE',   'production');
//*/

/********************************************************************************
 * Defines
 *******************************************************************************/

define('COOKIE_LIFETIME',   5); // 5 min
define('MAX_EXECUTION',     10); // 10 min
define('ENCODE',            'UTF-8');
define('TIMEZONE',          'UTC');
define('DS',                DIRECTORY_SEPARATOR);
define('ROUTES_PATH',       dirname(__DIR__) . DS . 'routes');
define('TEMPLATE_PATH',     dirname(__DIR__) . DS . 'views');
define('CACHE_PATH',        dirname(__DIR__) . DS . 'cache');
define('LOG_PATH',          dirname(__DIR__) . DS . 'LOG.txt');

/********************************************************************************
 * Settings
 *******************************************************************************/

ini_set('session.cookie_httponly',   1);
ini_set('session.use_only_cookies',  1);
ini_set('session.cookie_lifetime',  COOKIE_LIFETIME * 60);
ini_set('session.gc_maxlifetime',   COOKIE_LIFETIME * 60);
ini_set('post_max_size',            '50M');
ini_set('upload_max_filesize',      '50M');

date_default_timezone_set(TIMEZONE);

mb_internal_encoding(ENCODE);
mb_http_output(ENCODE);

session_cache_limiter(false);
set_time_limit( (MAX_EXECUTION * 60) );

if (MODE == 'production')
    error_reporting(0);


/********************************************************************************
 * Check extensions
 *******************************************************************************/

/*
if (!extension_loaded('')) {

}
*/

/********************************************************************************
 * App
 *******************************************************************************/

require "../vendor/autoload.php";

/**
 * Initialize the class AppLog
 *
 * The AppLog class manages fatal errors. It is also LogWriter of Slim.
 */
AppLog::getInstance()->setup(LOG_PATH);

register_shutdown_function(function () {
    $last_error = error_get_last();
    if (!is_null($last_error)) {
        AppLog::getInstance()->write(print_r($last_error, true), $last_error['type']);
        die(file_get_contents(TEMPLATE_PATH . DS . 'fatal_error.html'));
    }
});

/*
 * Logs errors that occurred before the $app->run()
 * and displays when in development mode
 */
set_error_handler(function ($errno, $errstr, $errfile, $errline) {

    $error = print_r(func_get_args(), true);

    AppLog::getInstance()->write($error , $errno);

    if (MODE == "development")
        die('<pre>'. $error . '</pre>');

}, E_ALL);

if ( ( (double) phpversion() ) < 5.5) {
    trigger_error('The system requires a minimum of PHP v5.5', E_USER_ERROR);
}

$view = new Blade();
$view->parserOptions = array(
    'debug' => true,
    'cache' => CACHE_PATH,
);

$app = new Slim(array(
    'mode' => MODE,
    'view' => $view,
    'templates.path' => TEMPLATE_PATH,
    'cookies.lifetime' => COOKIE_LIFETIME . ' minutes',
));

$app->configureMode('production', function () use ($app) {
    $app->config(array(
        'debug' => false,
        'log.enable' => true,
        'log.level' => Log::DEBUG,
        'log.writer' => AppLog::getInstance(),
    ));
});

$app->configureMode('development', function () use ($app) {

    $app->add(new MonitorMiddleware());

    $app->config(array(
        'debug' => true,
        'log.enable' => false,
    ));
});

/********************************************************************************
* Singletons
*******************************************************************************/

$db_config = require "../.db";

$app->container->singleton('DB', function() use ($app, $db_config) {

    $capsule = new Manager();
    $capsule->setFetchMode(PDO::FETCH_OBJ);
    $capsule->addConnection($db_config[$app->getMode()]);
    $capsule->bootEloquent();

    return $capsule->getConnection();
});

$app->container->singleton('Session', function() use ($app) {
    return Session::getInstance();
});

$app->container->singleton('Auth', function() use ($app) {
    return new Auth($app->DB, Session::getInstance());
});

/********************************************************************************
* Middlewares
*******************************************************************************/

/**
 * $needLogged Used on routes that require the user to be logged in
 */
$needLogged = function () use ($app) {
    if (!$app->Auth->isLoggedIn()) {
        $app->Session->set('error', 'You must be logged');
        $app->redirect('/login');
    }
};

/**
 * $needGuest Used on routes that do not accept logged in users
 */
$needGuest = function () use ($app) {
    if ($app->Auth->isLoggedIn()) {
        $app->redirect('/');
    }
};

/**
 * $needPermission Used on routes that require special permissions
 *
 * @param string $permission Description of permission that will be checked by the user logged in
 */
$needPermission = function ($permission) use ($app) {
    return function () use ($app, $permission) {
        if (!$app->Auth->havePermission($permission)) {
            $app->render('/403', array('page' => $app->request()->getPathInfo()));
            $app->stop();
        }
    };
};

/**
 * $needAdmin Used on routes that require the user to be an admin
 *
 * @param string $level Level of admin
 */
$needAdmin = function ($level = 3) use ($app) {
    return function () use ($app, $level) {
        if (!$app->Auth->isAdmin($level)) {
            $app->render('/403', array('page' => $app->request()->getPathInfo()));
            $app->stop();
        }
    };
};

/**
 * $maintenance Used on routes that are in maintenance
 */
$maintenance = function () use ($app) {
    $app->render('/maintenance', array('page' => $app->request()->getPathInfo()));
    $app->stop();
};

/********************************************************************************
 * Routes Core
 *******************************************************************************/

$app->error(function(\Exception $e) use ($app) {

    if ($e instanceof \SlimBase\AuthUserNotFound) {
        // Do something specific exceptions
    }

    $app->getLog()->error($e);
    $app->render('/500', array('message' => $e->getMessage()), 500);
});

$app->notFound(function () use ($app) {
    $app->render('/404');
});

$app->get('/403', $needLogged, function () use ($app) {
    $app->render('/403');
});

$app->get('/maintenance', $needLogged, function () use ($app) {
    $app->render('/maintenance');
});

/********************************************************************************
 * Hooks
 *******************************************************************************/

$app->hook("slim.before.router", function ()
use ($app, $needAdmin, $needGuest, $needLogged, $needPermission, $maintenance) {
    $path_info = $app->request()->getPathInfo();

     // Database query routes that are in maintenance
    $arr_routes_maintenance = $app->DB->table("routes_maintenance")->where("active", '>', '0')->lists('route');
    if (in_array($path_info, $arr_routes_maintenance))
        $maintenance();

    if (strpos($path_info, "/admin") === 0) {
        require_once ROUTES_PATH . DS . 'admin.route.php';
    } else {
        require_once ROUTES_PATH . DS . 'main.route.php';
    }
});

$app->run();
