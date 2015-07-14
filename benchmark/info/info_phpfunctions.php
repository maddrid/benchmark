<?php if (!defined('ABS_PATH'))
    exit('Access is not allowed.');



?>


<?php
// ALL USER DEFINED FUNCTIONS
$functions = get_defined_functions();

$sistem_functions = array();

$country = 'us';
foreach ($functions['internal'] as $key => $value){
$sistem_functions[$key]['function'] = $value ;
$sistem_functions[$key]['link'] =  'http://' . $country . '.php.net/' .$value  ;

}



debug_var($sistem_functions, 'Sistem Functions');

// ALL INTERNAL FUNCTIONS
?>


