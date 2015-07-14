<?php
if (!defined('ABS_PATH'))
    exit('cheating');

if (!osc_is_admin_user_logged_in()) {
    die;
}
$toemail = Params::getParam('toemail');
$param = Params::getParam('emailfields');



$Info = osc_plugin_get_info('benchmark/index.php');
?>

<div class="clear"></div><div class="clear"></div>
<?php require 'navigation.php'; ?>

<pre>Send info by email will be available next version</pre>

<?php
require'benchfooter.php';
?>

