<?php

/*
  Plugin Name: Benchmark Host
  Plugin URI: http://www.osclass.org/
  Description: Test your server
  Version: 1.0.3
  Author: Web-Media
  Author URI: http://forums.osclass.org/profile/?u=19775
  Short Name: benchmark

 */

//require_once "BenchmarkHost.php";
require_once "BenchmarkModel.php";
define('LINFO_URL', osc_plugin_url(__FILE__) . 'linfo/');
define('BENCHMARK_PATH', osc_plugin_path(__DIR__).'/' );
define('BENCHMARK_EMAILS_PATH', BENCHMARK_PATH.'emails/' );

function benchmark_install() {
    BenchmarkModel::newInstance()->import('benchmark/bench.sql');
}

function benchmark_uninstall() {
    BenchmarkModel::newInstance()->uninstall();
}
osc_add_hook('init', 'get_current_page');

function get_current_page (){
    global $current_page ;
    $current_page ['page']= $page =Params::getParam('page');
    $current_page ['action']= $action  =Params::getParam('action');
    $current_page ['file']= $file  =Params::getParam('file');
    $current_page ['route']= $route =Params::getParam('route');
   return $current_page    ;
    
}
if (OC_ADMIN) {
    
    function benchmark_send_options (){
        $options = array(
        'serverinfo' => 'Server Info',
        'dbinfo' => 'Database Info',
        'phpinfo' => 'Php Info',
        'phpfunctions' => 'Php functions',
        'oscfunctions' => 'Osclass functions',
        'test' => 'Test Results',
       
    );
        return $options;
    }
    
    function printNestedArray($a) {
    echo '<blockquote>';
    foreach ($a as $key => $value) {
      echo htmlspecialchars("$key: ");
      if (is_array($value)) {
        printNestedArray($value);
      } else {
        echo htmlspecialchars($value) . '<br />';
      }
    }
    echo '</blockquote>';
  }
     if (!function_exists('debug_extended')) {
         function debug_extended ($var = false, $title = '',$message =''){
             $startTime = microtime(true);
//
    $mem = memory_get_usage();

     debug_var($var);
    $memory_1 = memory_get_usage() - $mem;
   
     $total_time = sprintf('%.4f', microtime(true) - $startTime);
    
             
         }
     }
    
    if (!function_exists('debug_var')) {

        function debug_var($var = false, $title = '',$message ='') {
          
            if ($title != '') {
                echo "<h3>" . $title . '</h3>';
            }
            echo "<pre>";
            
            if (is_array($var)) {
                printNestedArray($var);
            } else {
                print_r($var. "\n");
            }
            
            echo "</pre>";
            if ($message != '') {
                echo "<div class =\"pre\">" . $message . '</div>';
            }
            
        }

    }

    function FormatSize($size) {
        $postfix = array('b', 'Kb', 'Mb', 'Gb', 'Tb');

        $position = 0;
        while ($size >= 1024 && $position < 4) {
            $size /= 1024;
            $position++;
        }

        return array(
            'value' => round($size, 2),
            'postfix' => $postfix[$position]
        );
    }

    /**
     * Un Format Size.
     * @param string|array $size
     * @param string $postfix
     * @return float
     * @static
     * @final
     */
    function UnFormatSize($size, $postfix = 'b') {
        if (is_array($size)) {
            if (isset($size['value']) && isset($size['postfix'])) {
                $postfix = $size['postfix'];
                $size = $size['value'];
            } else {
                return 0;
            }
        }

        $result = $size;

        switch ($postfix) {
            case 'Kb':
                $result *= 1024;
                break;
            case 'Mb':
                $result *= 1048576;
                break;
            case 'Gb':
                $result *= 1073741824;
                break;
            case 'Tb':
                $result *= 1099511627776;
                break;
        }

        return $result;
    }

    function convert_usage($mem_usage) {
        $return = '';
        if ($mem_usage < 1024) {
            $return = $mem_usage . " bytes";
        } elseif ($mem_usage < 1048576) {
            $return = round($mem_usage / 1024, 5) . " KB";
        } else {
            $return = round($mem_usage / 1048576, 5) . " MB";
        }
        return $return;
    }

    function benchmarkTitle($title) {
        $title = 'Plugin - Benchmark Host';
        return $title;
    }

    if (osc_version() >= 300) {
        $file = explode('/', Params::getParam('file'));
        if ($file[0] == 'benchmark') {

            osc_add_filter('custom_plugin_title', 'benchmarkTitle');
        }
    }
osc_add_hook('admin_header', 'benckmark_admin_header');

    function benckmark_admin_header() {
        ?>
        <style>
           
             #menu_benchmark{
/*            box-shadow: 0 0 0 1px #bababe inset;*/
            background: transparent url('<?php echo osc_plugin_url('benchmark'); ?>benchmark/menu/plugin-ico.png') 5px 5px no-repeat scroll !important;      
        }
        .ico-benchmark{
            background-image: url('<?php echo osc_plugin_url('benchmark'); ?>benchmark/menu/sprite.png') !important;
            background-position: 0 0;
        }
        li:hover .ico-benchmark,
        .current .ico-benchmark{
            background-position: -48px 0;
        }
        body.compact .ico-benchmark{
            background-image: url('<?php echo osc_plugin_url('benchmark'); ?>benchmark/menu/sprite.png') !important;
            background-position: -10px -55px;
        }
        body.compact li:hover .ico-benchmark,
        body.compact li.current .ico-benchmark{
            background-position: -57px -55px;
        </style>
        <?php
    }
	 osc_add_hook('admin_menu_init', 'benchmark_admin_menu');

    function benchmark_admin_menu() {
        osc_add_admin_menu_page('Benchmark Host', osc_admin_render_plugin_url("benchmark/help.php"), 'benchmark', 'administrator');
        osc_add_admin_submenu_page('benchmark', 'Help', osc_admin_render_plugin_url("benchmark/help.php"), 'benchmark_help', 'administrator');
     }
   

    function benchmark_help() {
        osc_admin_render_plugin(osc_plugin_path(dirname(__FILE__)) . '/help.php');
    }

    osc_add_hook('admin_menu_init', 'benchmark_admin_menu');
    osc_add_hook(osc_plugin_path(__FILE__) . "_configure", 'benchmark_help');
}

function bench_js_redirect_to($url) {
    ?>
    <script type="text/javascript">
        window.location = "<?php echo $url; ?>"
    </script>
    <?php
}

osc_register_plugin(osc_plugin_path(__FILE__), 'benchmark_install');
osc_add_hook(osc_plugin_path(__FILE__) . "_uninstall", 'benchmark_uninstall');
?>
