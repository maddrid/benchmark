<?php if ( ! defined('ABS_PATH')) exit('cheating');

if (!osc_is_admin_user_logged_in()) {
    die;
}
require 'navigation.php'; 
require 'info/info_server.php';
require 'benchfooter.php';
 ?>


