<?php if ( ! defined('ABS_PATH')) exit('cheating'); 
$Info = osc_plugin_get_info('benchmark/index.php');
?>
<style>
    .wide{
        width:100%;
    }
</style>
<div class="wide"></div>
<p class="form-row">
    <span class="help-box"><?php echo'Version'; ?>: <?php echo $Info['version']; ?></span><br />
    <span class="help-box"><?php echo'Description'; ?>: <?php echo $Info['description']; ?></span><br />
    <span class="help-box"><?php echo'Author'; ?>: <?php echo $Info['author']; ?></span><br />
    <span class="help-box"><?php echo'Find me here : '; ?>: <a href="<?php echo $Info['author_uri']; ?>" target="_blank"><?php echo $Info['author_uri']; ?></a></span><br />
    <span class="help-box"><?php echo'Plugin forum here : '; ?>: <a href="http://forums.osclass.org/plugins/%28plugin%29-benchmark-your-host" target="_blank">Forum post</a></span>

</p>