<?php

// Autoloader
define('DIR_VENDOR', __DIR__.'/../vendor/');

if (file_exists(DIR_VENDOR . 'autoload.php')) {
    require_once(DIR_VENDOR . 'autoload.php');
}

/*
echo "Hello World";
echo "<br>\n********************<br>\n";
//$_SERVER["REQUEST_URI"]
echo "<pre>".print_r($_SERVER, true)."</pre>";
echo "<br>\n********************<br>\n";

*/

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

echo "<br>\n*********ENV*********<br>\n";
echo "<pre>".print_r($_ENV, true)."</pre>";
echo "<br>\n********************<br>\n";

echo "END<br>\n";