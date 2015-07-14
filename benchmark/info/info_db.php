<?php  if (!defined('ABS_PATH'))
    exit('Access is not allowed.');

?>

   <?php

$version = BenchmarkModel::newInstance()->Version();
debug_var($version,'Database version');

$profiles = BenchmarkModel::newInstance()->showProfiles();
debug_var($profiles ,'Mysql Profiler For Query_ID 1');


$sql_mode = BenchmarkModel::newInstance()->getSqlMode();
debug_var($sql_mode,'Sql Mode');

$uptime = BenchmarkModel::newInstance()->UpTime();
debug_var($uptime,'Database Up Time');

$buffers = BenchmarkModel::newInstance()->GlobalBuffers();
debug_var($buffers,'Global Buffers');

$cbuffers = BenchmarkModel::newInstance()->ConnectionBuffers();
debug_var($cbuffers,'Connection Buffers');


$maxcon = BenchmarkModel::newInstance()->MaxConnections();
debug_var($maxcon,'Maxx connection');
$maxpacket = BenchmarkModel::newInstance()->MaxPacket();
debug_var($maxpacket,'MAX ALLOWED PACKET ','This value indicates maximum size of one packet sent to database');

$tdif = BenchmarkModel::newInstance()->TimeDiff();
debug_var($tdif,'Time Diference');

$cache_enabled = BenchmarkModel::newInstance()->CacheEnabled();
debug_var($cache_enabled ,'Querry Cache Enabled');

$cache_variables = BenchmarkModel::newInstance()->CacheVariables();
debug_var($cache_variables ,'Querry Cache Size');


$cache_enabled = BenchmarkModel::newInstance()->CacheStatus();
debug_var($cache_enabled ,'Cache Status');

$cache_efective = BenchmarkModel::newInstance()->RCacheEffectiveness();
debug_var($cache_efective ,'Cache Efectiveness');
$inno_vars = BenchmarkModel::newInstance()->InnoDbVariables();
debug_var($inno_vars, ' InnoDB variables.');
$inno_buffer = BenchmarkModel::newInstance()->InnodbBufferEffectiveness();
debug_var($inno_buffer, ' InnoDB buffer effectiveness.');

$sorts = BenchmarkModel::newInstance()->Sorts();
debug_var($sorts,'Total sorts.');

$r_temp_table = BenchmarkModel::newInstance()->RateTemporaryTables();
debug_var($r_temp_table,'Rate of temporary tables requiring temporary disk space.');

$treads = BenchmarkModel::newInstance()->ThreadCacheEfficiency();
debug_var($treads,'Thread cache efficiency.');

$op_eff = BenchmarkModel::newInstance()->OpenTableCacheEfficiency();
debug_var($op_eff,'Open table cache efficiency.');

$op_file = BenchmarkModel::newInstance()->OpenFiles();
debug_var($op_file,'Rate of open files..');

$c_abort = BenchmarkModel::newInstance()->ConnectionAborts();
debug_var($c_abort,'Rate of incorrectly closed connections.');



$count_rows = BenchmarkModel::newInstance()->CountRow();
debug_var($count_rows ,' Database Rows /Table');


$status_global = BenchmarkModel::newInstance()->showGlobalVariables();
debug_var($status_global,' Mysql Global Variables');

$status_session = BenchmarkModel::newInstance()->showSessionVariables();
debug_var($status_session,'Mysql Session Variables');


$status = BenchmarkModel::newInstance()->showStatus();
debug_var($status,' Status');


?>
