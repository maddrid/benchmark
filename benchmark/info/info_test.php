<?php  if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
if (!osc_is_admin_user_logged_in()) {
    die;
}
ini_set('max_execution_time', 100);
ini_set('xdebug.max_nesting_level', 200000);
require BENCHMARK_PATH."BenchmarkHost.php";
require BENCHMARK_PATH.'benchclass.php';



$memoryStart = memory_get_peak_usage();

?>

    <?php
    $startTime = microtime(true);

    $mem = memory_get_usage();
  $memoryStart = memory_get_peak_usage(false);
   $array = BenchmarkHost::bench_networkspeed();
   // Get used memory
    $memoryUsed = memory_get_peak_usage(false);

  
    $memoryDiff = $memoryUsed - $memoryStart;
   $memory = memory_get_usage() - $mem;
  $array['memory'] = convert_usage($memory);
$array['memoryPeak'] = convert_usage($memoryDiff );
//
   debug_var($array, 'Network speed');
//
//
//
    $mem = memory_get_usage();
    $memoryStart = memory_get_peak_usage(false);
    $array = BenchmarkHost::bench_database();
   $memory = memory_get_usage() - $mem;
    $memoryUsed = memory_get_peak_usage(false);

    
    $memoryDiff = $memoryUsed - $memoryStart;
   $array['memory'] = convert_usage($memory);
    $array['memoryPeak'] = convert_usage($memoryDiff );
    debug_var($array, 'Database speed');
//
//
//

   $mem = memory_get_usage();
   $memoryStart = memory_get_peak_usage(false);
    $array = BenchmarkHost::bench_cpu();
    $memory = memory_get_usage() - $mem;
       $memoryUsed = memory_get_peak_usage(false);
//
//    
   $memoryDiff = $memoryUsed - $memoryStart;
   $array['memory'] = convert_usage($memory);
    $array['memoryPeak'] = convert_usage($memoryDiff );
   debug_var($array, 'Cpu speed');

   $mem = memory_get_usage();
   $memoryStart = memory_get_peak_usage(false);
    $array = BenchClass::run();
   $memory = memory_get_usage() - $mem;
   $memoryUsed = memory_get_peak_usage(false);
//
//    
   $memoryDiff = $memoryUsed - $memoryStart;
   $array['memory'] = convert_usage($memory);
     $array['memoryPeak'] = convert_usage($memoryDiff );
    debug_var($array, 'Benchmark');
//  
    
    $mem= memory_get_usage();
    $memoryStart = memory_get_peak_usage(false);
    
    $array = array();
   $array = BenchmarkHost::bench_file_create();
    $memoryUsed = memory_get_peak_usage(false);

    
    $memoryDiff = $memoryUsed - $memoryStart;
    $memory = memory_get_usage() - $mem;
    $array['memory'] = convert_usage($memory);
    $array['memoryPeak'] = convert_usage($memoryDiff );
   
    debug_var($array, 'Time to Create 1000 files');
    
    
    $mem= memory_get_usage();
    $memoryStart = memory_get_peak_usage(false);
    $item_time = microtime(true);
    $array = array();
   $array = BenchmarkHost::bench_item();
    $memoryUsed = memory_get_peak_usage(false);

    
    $memoryDiff = $memoryUsed - $memoryStart;
    $memory = memory_get_usage() - $mem;
    $array['memory'] = convert_usage($memory);
    $array['memoryPeak'] = convert_usage($memoryDiff );
   
    debug_var($array, 'Insert Item');
    $dummy_item = new BenchmarkItem ();
    $success = $dummy_item->deleteDummyItem();
	
    $total_time = sprintf('%.4f', microtime(true) - $startTime);
    echo'<h3> Total  Test Time = ' . $total_time . ' s</h3>';
    $memoryUsed = memory_get_peak_usage();
    $memoryAvailable = filter_var(ini_get("memory_limit"), FILTER_SANITIZE_NUMBER_INT);
    $memoryAvailable = $memoryAvailable * 1024 * 1024;
    $percentage = ($memoryUsed / $memoryAvailable) * 100;
    echo '<h3>Memory peak = ' . convert_usage($memoryUsed) . '</h3>';
    echo '<h3>PERCENTAGE = ' . $percentage . '% .</h3>';


    ?>
   

 

