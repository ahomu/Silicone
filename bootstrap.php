<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);

define('DIR_ROOT',     dirname(__FILE__).'/');
define('DIR_VENDOR',   DIR_ROOT.'vendor/');
define('DIR_DOMAINS',  DIR_ROOT.'domains/');
define('DIR_PUBLIC',   DIR_ROOT.'public/');
define('DIR_TEMPLATES',DIR_ROOT.'templates/');

require DIR_ROOT.'silex.phar';
require DIR_VENDOR.'Silicone/Application.php';
require DIR_VENDOR.'brtriver/PHPTALServiceProvider/PHPTALServiceProvider.php';

function d($a) {
    echo '<pre>';
    var_dump($a);
    echo '</pre>';
}
