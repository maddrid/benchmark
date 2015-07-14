<?php if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}
ini_set('max_execution_time', 100);
ini_set('xdebug.max_nesting_level', 200000);


require 'navigation.php';
require'info/info_test.php';
require'benchfooter.php';

?>