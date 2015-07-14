<?php

if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}

?>
<style>
    .half {
        width:49%;
        float: left; padding: 5px;
          word-wrap: break-word; 
    }
    pre.pree {
          word-wrap: break-word; 
        background-color: white;
    
}
</style>
<?php require 'navigation.php';      ?>
   <div class="clear"></div>
   <div class ="half">
   <?php
require 'info/info_db.php'

?>
</div>
   
   <div class=" well half">
       <pre class = "pree">
How to change the MySQL configuration

MySQL keeps its configuration stored in the my.cnf file. In general, you will find the config file at /etc/mysql/my.cnf.

When you change the configuration file, you will need to restart your MySQL server to reload the changes.

However, if you feel like you want to do the changes on runtime, you can use the SET GLOBAL and SET SESSION query.
Do note that not all config variables are available to be set on runtime and the changes are not persistent.
 Please consult the following list to see if the variable can be changed: <a href="http://dev.mysql.com/doc/refman/5.5/en/dynamic-system-variables.html" target="_blank">Dynamic system variables</a>
    <p>
One tool is <a href="http://mysqltuner.com/" target="_blank" >MySQLTuner</a>
. This tool will analyze the performance of your MySQL server and suggest changes. In general, you should only run this tool when your MySQL server has already been running for a couple of days. After you changed the configuration, you should wait another couple of days and run it again.
</p>  

	  </pre>
       <pre class="pree">
Check your database version first .
More details here : 

           <a href ="https://dev.mysql.com/doc/refman/5.1/en/query-cache.html" target="_blank">https://dev.mysql.com/doc/refman/5.1/en/query-cache.html</a>
          <a href ="https://dev.mysql.com/doc/refman/5.5/en/innodb-buffer-pool.html" target="_blank" >https://dev.mysql.com/doc/refman/5.5/en/innodb-buffer-pool.html</a>
          
 
       </pre>
   </div>  
   
   <?php 
require'benchfooter.php';

?>