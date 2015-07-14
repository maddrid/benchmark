<?php  if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}

?>
<?php require 'navigation.php';      ?>
<?php require 'info/info_oscfunctions.php';      
$sistem_functions = array();

$country = 'us';
foreach ($functions['internal'] as $key => $value){
$sistem_functions[$key]['function'] = $value ;
$sistem_functions[$key]['link'] =  'http://' . $country . '.php.net/' .$value  ;

}



debug_var($sistem_functions, 'Sistem Functions');
 require 'benchfooter.php';     
 ?>