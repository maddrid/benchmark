<?php if ( ! defined('ABS_PATH')) exit('cheating');

if (!osc_is_admin_user_logged_in()) {
    die;
}
osc_show_flash_message('admin');
?>
<style>
#clearmenu {
height: 44px;
    margin-bottom: 16px;
}
</style>
<h2>Help us improve this plugin</h2>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
        <input type="hidden" name="cmd" value="_s-xclick">
        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
               ">
        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
        <img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
    </form>

<div id= "clearmenu">
    <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/help.php'); ?>">Help</a></h2>
    <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/bench_test.php'); ?>">Test Your Server</a></h2>
    <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/bench_server.php'); ?>">Server Info</a></h2>
    <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/bench_db.php'); ?>">Database Info</a></h2>
    <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/bench_php.php'); ?>">Php info</a></h2>
   <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/bench_functions.php'); ?>">Php available functions</a></h2>
   
   <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/email.php'); ?>">Email</a></h2>
   <h2> <a class ="btn btn-green" href ="<?php echo osc_admin_render_plugin_url('benchmark/save.php'); ?>">Save Info</a></h2>
 </div>   
    