<?php if ( ! defined('ABS_PATH')) exit('cheating');



//define('LINFO_LOCAL_PATH', dirname(__FILE__) . '/');
require_once BENCHMARK_PATH.'linfo/init.php';

// Begin
try {

  // Load settings and language
	$linfo = new Linfo;

  // Run through /proc or wherever and build our list of settings
	$linfo->scan();

  // Give it off in html/json/whatever
	$linfo->output();
}

// No more inline exit's in any of Linfo's core code!
catch (LinfoFatalException $e) {
	echo $e->getMessage()."\n";
	exit(1);
}
?>
