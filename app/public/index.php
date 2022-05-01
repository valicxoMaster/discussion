<?php
define('DIR_VENDOR', __DIR__.'/../vendor/');

use App\Application;

// Autoloader
require_once(DIR_VENDOR . 'autoload.php');

Application::run();