<?php

if (!defined('ABS_PATH'))
    exit('Access is not allowed.');

class BenchmarkModel extends DAO {

    private static $startTime = 0;
    private static $lipsum = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.";

    public static function startTimer() {
        self::$startTime = microtime(true);
    }

    public static function getTimer() {
        return sprintf('%.4f', microtime(true) - self::$startTime);
    }

    private static $instance;

    public static function newInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    function __construct() {
        parent::__construct();
    }

    public function table_benchmark_host() {
        return DB_TABLE_PREFIX . 't_benchmark_host';
    }

    public function insert_value($string, $text) {
        return $this->dao->insert($this->table_benchmark_host(), array('string' => $string, 'valuess' => $text));
    }

    public function delete_value($string) {
        return $this->dao->delete($this->table_benchmark_host(), array('string' => $string));
    }

    public function update_value($string) {
        return $this->dao->update($this->table_benchmark_host(), array('valuess' => 'Updated data'), array('string' => $string));
    }

    public function get_value($string) {
        $this->dao->select();
        $this->dao->from($this->table_benchmark_host());
        $this->dao->where('string', $string);
        $this->dao->limit(1);
        $result = $this->dao->get();
        if (!$result) {
            return array();
        }

        return $result->row();
    }

    public function Version() {
        $version = $this->dao->query('SELECT version();');
        $mysql = $version->row();
        if (empty($mysql) || is_null($mysql)) {
            return false;
        }
        $return = $mysql['version()'];
        return $return;
    }

    
    
    /**
     * Working time database startup.
     * @return string|boolean
     * @final
     */
    public function UpTime() {


        $uptimes = $this->dao->query('SHOW GLOBAL STATUS LIKE \'Uptime\'');
        $uptimes = $uptimes->row();
        if (empty($uptimes) || is_null($uptimes)) {
            return false;
        }
        $uptime = $uptimes['Value'];

        $uptime = array(
            'days' => (int) ($uptime / 86400),
            'hours' => (int) (($uptime % 86400) / 3600),
            'minutes' => (int) (($uptime % 3600) / 60),
            'seconds' => (int) ($uptime % 60)
        );

        return "{$uptime['days']}d {$uptime['hours']}h {$uptime['minutes']}m {$uptime['seconds']}s";
    }

    public function showStatus() {


      $variables = $this->dao->query('SHOW STATUS');
        

      $array = array();
       foreach ($variables->result() as $row) {
           $array [$row['Variable_name']] = $row['Value'];
       }
        return $array;
    }
    
    public function showGlobalVariables() {


      $variables = $this->dao->query('SHOW GLOBAL VARIABLES');
        

        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = convert_usage($row['Value']);
        }
        return $array;
    }
    
     public function showSessionVariables() {


      $variables = $this->dao->query('SHOW SESSION VARIABLES');
        

        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = convert_usage($row['Value']);
        }
        return $array;
    }
	public function showProfiles() {
	$this->dao->query("set profiling_history_size=100");
	$this->dao->query("set profiling=1");
	Category::newInstance()->listAll();
	$array = array();
	   $time = '';
	 $variables = $this->dao->query('SHOW PROFILES;');
	  $array ['querries'] =$variables->result();
     $variables = $this->dao->query('SHOW PROFILE FOR QUERY 1;');
        
       
        foreach ($variables->result() as $row) {
            $array ['profiler'][$row['Status']] = $row['Duration'];
			$time +=$row['Duration'];
        }
		$array ['time'] = $time;
        return $array;
    }
    public function GlobalBuffers() {


        $variables = $this->dao->query(
                "SHOW
                GLOBAL VARIABLES
             WHERE
                Variable_name
             IN
                (
                    'key_buffer_size',
                    'tmp_table_size',
                    'innodb_buffer_pool_size',
                    'innodb_additional_mem_pool_size',
                    'innodb_log_buffer_size',
                    'query_cache_size',
                    'max_heap_table_size'
                 )"
        );

        $result = 0;
        if (empty($variables) || is_null($variables)) {
            return false;
        }
        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = convert_usage($row['Value']);
        }



        if (
                isset($array['tmp_table_size']) &&
                isset($array['max_heap_table_size']) &&
                $array['tmp_table_size'] > $array['max_heap_table_size']
        ) {
            $result += $array['max_heap_table_size'];
        } elseif (isset($array['tmp_table_size'])) {
            $result += $array['tmp_table_size'];
        }

        if (isset($array['innodb_buffer_pool_size'])) {
            $result += $array['innodb_buffer_pool_size'];
        }

        if (isset($array['innodb_additional_mem_pool_size'])) {
            $result += $array['innodb_additional_mem_pool_size'];
        }

        if (isset($array['innodb_log_buffer_size'])) {
            $result += $array['innodb_log_buffer_size'];
        }

        if (isset($array['query_cache_size'])) {
            $result += $array['query_cache_size'];
        }


        return $array;
    }

    public function ConnectionBuffers() {


        $variables = $this->dao->query(
                "SHOW
                GLOBAL VARIABLES
             WHERE
                Variable_name
             IN
                (
                    'read_buffer_size',
                    'read_rnd_buffer_size',
                    'sort_buffer_size',
                    'thread_stack',
                    'join_buffer_size'
                 )"
        );

        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = convert_usage($row['Value']);
        }

        return $array;
    }

	/**
     * Max. connections.
     * @return array|boolean
     * @final
     */
    public function MaxPacket() {

        $variables = $this->dao->query('SHOW GLOBAL VARIABLES LIKE \'max_allowed_packet\'');

        $mysql = $variables->row();
        if (empty($mysql) || is_null($mysql)) {
            return false;
        }
        $return = convert_usage($mysql['Value']);
        return $return;
    }
	
    /**
     * Max. connections.
     * @return array|boolean
     * @final
     */
    public function MaxConnections() {

        $variables = $this->dao->query('SHOW GLOBAL VARIABLES LIKE \'max_connections\'');

        $mysql = $variables->row();
        if (empty($mysql) || is_null($mysql)) {
            return false;
        }
        $return = $mysql['Value'];
        return $return;
    }

    /**
     * Checking the time difference.
     * @return boolean
     * @final
     */
    public function TimeDiff() {

        $s = date("Y-m-d H:i:s");

        $variables = $this->dao->query('SELECT NOW() AS `time`');
        $time = $variables->row();

        $array = array();
        $array['php'] = $s;
        $array['mysql'] = $time['time'];
        return $array;
    }

    public function bench_database() {

        $text = "";
        for ($i = 0; $i < 20; $i++) { //50 paragraphs, mimicking a large blog entry or page of content that includes HTML source.
            $text .= self::$lipsum . ' ';
        }
        $namePref = 'hostTest0188_';
        $iterations = 150;
        $total_time = 0;
        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $this->insert_value($namePref . $i, $text);
        }
        $total_time+=$insert_time = sprintf('%.4f', microtime(true) - $start);

        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $this->get_value($namePref . $i);
        }
        $total_time+=$get_time = sprintf('%.4f', microtime(true) - $start);
        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $this->update_value($namePref . $i);
        }
        $total_time+=$update_time = sprintf('%.4f', microtime(true) - $start);
        $start = microtime(true);
        for ($i = 0; $i < $iterations; $i++) {
            $this->delete_value($namePref . $i);
        }
        $total_time+=$delete_time = sprintf('%.4f', microtime(true) - $start);
        $qinsert = round($iterations / $insert_time);
        $qget = round($iterations / $get_time);
        $qupdate = round($iterations / $update_time);
        $qdelete = round($iterations / $delete_time);
        $array = array();
        $array['time'] = $total_time;
        $qq = ' queries/s';

        $array['tests']['insert'] = $qinsert . $qq;
        $array['tests']['select'] = $qget . $qq;
        $array['tests']['update'] = $qupdate . $qq;
        $array['tests']['delete'] = $qdelete . $qq;


        return $array;
    }

    /**
     * Gets the number of records in the tables.
     * @return array|boolean
     * @final
     */
     public function CountRow() {


        $result = false;
        $array = array();
        $variables = $this->dao->query('SHOW TABLES');
        foreach ($variables->result() as $row => $tab) {
            $tt = 'Tables_in_'.DB_NAME;
            $table = $tab[$tt];
            

            $count = $this->dao->query("SELECT COUNT(0) FROM $table");
            $_count = $count->row();
            $array [$table] = $_count['COUNT(0)'];
        }
        return $array;
    }
   
 public function getSqlMode (){
//     $this->dao->query("SET @@session.sql_mode = 'MYSQL40'");
     $variables = $this->dao->query('SELECT @@sql_mode');

         $mysql= $variables->row();
//        if (empty($mysql) || is_null($mysql)) {
//            return false;
//        }
//        $return = $mysql['Value'];
        return $mysql ;
     
 }
     public function CacheEnabled() {

        $variables = $this->dao->query('SHOW  VARIABLES LIKE \'have_query_cache\'');

        $mysql = $variables->row();
        if (empty($mysql) || is_null($mysql)) {
            return false;
        }
        $return = $mysql['Value'];
        return $return ;
    }
    
   
    public function CacheVariables() {

        $variables = $this->dao->query('SHOW  VARIABLES LIKE \'query_cache%\'');

       $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
         return $array;
    }

    public function CacheStatus() {

        $variables = $this->dao->query('SHOW STATUS LIKE \'Qc%\'');

       $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
         return $array;
    }
    public function RCacheEffectiveness() {


        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Qcache_hits', 'Com_select', 'Qcache_not_cached')"
        );
        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
        if (isset($array['Qcache_hits']) && isset($array['Com_select']) && isset($array['Qcache_not_cached'])) {
            $result = round($array['Qcache_hits'] / (($array['Com_select'] - $array['Qcache_not_cached']) + $array['Qcache_hits']) * 100, 2);
            $array['efective'] = $result . '%';
        }

        return $array;
    }
public function InnoDbVariables() {

        $variables = $this->dao->query('SHOW  VARIABLES LIKE \'Innodb_%\'');

       $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
         return $array;
    }
    public function InnodbBufferEffectiveness() {

        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Innodb_buffer_pool_reads', 'Innodb_buffer_pool_read_requests')"
        );

        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = convert_usage($row['Value']);
        }

        return $array;
    }

    public function Sorts() {


        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Sort_scan', 'Sort_range')"
        );

        $result = 0;
        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
            $result += $row['Value'];
        }
        $array['Total'] = number_format($result, 0, '.', ' ');
        return $array;
    }

    public function RateTemporaryTables() {

        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Created_tmp_disk_tables', 'Created_tmp_tables')"
        );


        $result = 0;
        $array = array();
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
        if (isset($array['Created_tmp_disk_tables']) && isset($array['Created_tmp_tables'])) {
            $result = round(($array['Created_tmp_disk_tables'] / ($array['Created_tmp_tables'] + $array['Created_tmp_disk_tables'])) * 100, 2);
        }

        $array['Rate'] = $result;
        return $array;
    }

    public function ThreadCacheEfficiency() {


        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Threads_created', 'Connections')"
        );

        $array = array();
        $result = 0;
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }

        if (isset($array['Threads_created']) && isset($array['Connections'])) {
            $result = round(100 - (($array['Threads_created'] / $array['Connections']) * 100), 2);
        }

        $array['Efficiency'] = $result;
        return $array;
    }

    public function OpenTableCacheEfficiency() {

        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Open_tables', 'Opened_tables')"
        );

        $array = array();
        $result = 0;
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }
        if (isset($array['Open_tables']) && isset($array['Opened_tables'])) {
            $result = round($array['Open_tables'] / $array['Opened_tables'] * 100, 2);
        }

        $array['Efficiency'] = $result . '%';
        return $array;
    }

    public function OpenFiles() {

        $querys = array(
            'SHOW GLOBAL VARIABLES LIKE \'open_files_limit\'',
            'SHOW GLOBAL STATUS LIKE \'Open_files\''
        );
        $array = array();

        foreach ($querys as $query) {
            $variables = $this->dao->query($query);

            foreach ($variables->result() as $row) {
                $array [$row['Variable_name']] = $row['Value'];
            }
        }

        $result = 0;

        if (isset($array['Open_files']) && isset($array['open_files_limit'])) {
            $result = round($array['Open_files'] / $array['open_files_limit'] * 100, 2);
        }

        $array['Efficiency'] = $result . '%';
        return $array;
    }

    public function ConnectionAborts() {

        $variables = $this->dao->query(
                "SHOW
                GLOBAL STATUS
             WHERE
                Variable_name
             IN
                ('Aborted_connects', 'Connections')"
        );

        $array = array();
        $result = 0;
        foreach ($variables->result() as $row) {
            $array [$row['Variable_name']] = $row['Value'];
        }

        if (isset($array['Aborted_connects']) && isset($array['Connections'])) {
            $result = round(($array['Aborted_connects'] / $array['Connections']) * 100, 2);
        }

        $array['Rate'] = $result . '%';
        return $array;
    }

    public function import($file) {
        $path = osc_plugin_resource($file);
        $sql = file_get_contents($path);
        if (!$this->dao->importSQL($sql)) {
            throw new Exception("Error importSQL::BenchmarkModel<br>" . $file);
        }
    }

    public function uninstall() {
        $this->dao->query(sprintf('DROP TABLE %s', $this->table_benchmark_host()));
    }

    function _update($table, $values, $where) {
        $this->dao->from($table);
        $this->dao->set($values);
        $this->dao->where($where);
        return $this->dao->update();
    }

}

?>