<?php

date_default_timezone_set("Africa/Casablanca");
/**
  In practise, upload requests are limited by:

  The number of simultaneous uploads:
 *  How many concurrent AJAX (XmlHttpRequest) 
 * requests are allowed in popular browsers?
 * 
  The configured limit on the web server, eg.
 * LimitRequestBody on Apache,
 *  client_max_body_size on Nginx.
  The limits in the server-side scripting environment, e.g.
 * upload_max_filesize and post_max_size in PHP.
 * 
  Memory limits (bugs, client-side or server-side).
 */
ini_set('upload_max_filesize', '100M');
ini_set('post_max_size', '100M');

if (!ini_get('display_errors')) {
    ini_set('display_errors', '1');
}
if (!defined("ROOT")) {
    define('D_S', DIRECTORY_SEPARATOR);
    define('ROOT', dirname(__DIR__) . D_S);
    define('ROOT_WEB', "");
}
require_once ROOT . "vendor" . D_S . "autoload.php";



/**
 * set le module de applicaton
 */
require ROOT . "Bootstrap" . D_S . "Module.php";
/**
 * migrate par web si besoin
 * true or false
 */
require_once ROOT . "Bootstrap" . D_S . "PhinxWeb.php";





