<?php  if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}
ini_set('max_execution_time', 100);
ini_set('xdebug.max_nesting_level', 200000);








 function phpinfos()
    {
        ob_start();                                                                                                        
        @phpinfo();                                                                                                     
        $phpinfo = ob_get_contents();                                                                                         
        ob_end_clean();  
        //strip the body html                                                                                                  
        return preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $phpinfo);
    }

print_r(phpinfos());
    ?>
