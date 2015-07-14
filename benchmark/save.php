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

<pre>Select  info to save . (Be pacient may take some time.)(Info will be  pdf ) </pre>
<div class="clear"></div><div class="clear"></div>
<div id="item-form">
    <form  id="email_form" action="<?php echo osc_plugin_url(__FILE__),'emanager.php'; ?>" method="post"enctype="multipart/form-data">
        <input type="hidden" name="benchmark_action" value="save_file" />
    <div id="left-side">
    <?php
    $options = benchmark_send_options ();
    $option = '';
    $option .= "<option  value=\"\">" . 'Select  ' . "</option>";

    foreach ($options as $opt => $optvalue) {
        $option .= ($opt == $param) ? "<option value=\"$opt\" selected=\"selected\">$optvalue</option>\n" : "<option value=\"$opt\">$optvalue</option>\n";
    }
    echo "<select  name=\"eTest\" class=\"selectbox\" >$option</select>\n";
    ?>
    </br>
    </br>
 
    <input type="submit" value="Save file" class="btn btn-submit">
    </div>
</form>
    </div>
<?php
require'benchfooter.php';
?>

