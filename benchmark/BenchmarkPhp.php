<?php
define ('TEST_RESULT_OK', -1);

define ('TEST_RESULT_NOTICE', -2);

define ('TEST_RESULT_WARN', -4);

define ('TEST_RESULT_ERROR', -1024);

define ('TEST_RESULT_NOTRUN', -2048);

class BenchmarkPhp {

    private static $startTime = 0;

    public static function startTimer() {
        self::$startTime = microtime(true);
    }

    public static function getTimer() {
        return sprintf('%.6f', microtime(true) - self::$startTime);
    }
    
  public static  function returnBytes($val) {
        $val = trim($val);

        if ( (int)$val === 0 ) {
            return 0;
        }

        $last = strtolower($val{strlen($val)-1});
        switch($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }
/**
	 * This method converts the several possible return values from
	 * allegedly "boolean" ini settings to proper booleans
	 *
	 * Properly converted input values are: 'off', 'on', 'false', 'true', '', '0', '1'
	 * (the last two might not be neccessary, but I'd rather be safe)
	 *
	 * If the ini_value doesn't match any of those, the value is returned as-is.
	 *
	 * @param string $ini_key   the ini_key you need the value of
	 * @return boolean|mixed
	 */
    public static function getIniValue($ini_key) {

        $ini_val = ini_get($ini_key);

        switch ( strtolower($ini_val) ) {

            case 'off':
                return false;
                break;
            case 'on':
                return true;
                break;
            case 'false':
                return false;
                break;
            case 'true':
                return true;
                break;
            case '0':
                return false;
                break;
            case '1':
                return true;
                break;
            case '':
                return false;
                break;
            default:
                return $ini_val;

        }
    }
    
    /**
	 * This just does the usual PHP string casting, except for
	 * the boolean FALSE value, where the string "0" is returned
	 * instead of an empty string
	 *
	 * @param mixed $val
	 * @return string
	 */
  private static  function getStringValue($val) {
        if ($val === FALSE) {
            return "0";
        } else {
            return (string)$val;
        }
    }
	private static function test_suhosin() {
        $value = array();
		$value['compare'] = 'no';
//        $value['Recommended'] = '';
                
                
        $value['Current'] = ini_get('suhosin.session.max_id_length') ;
        return $value;
    }
    
    private static function test_allow_url_fopen() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('allow_url_fopen');
        return $value;
    }

    private static function test_allow_url_include() {
        $value = array();
//        $value['Recommended'] = FALSE;
        $value['Current'] = self::getIniValue('allow_url_include');
        return $value;
    }

    private static function test_expose_php() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('expose_php');
        return $value;
    }

    private static function test_log_errors() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('log_errors');
        return $value;
    }

    private static function test_html_errors() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('html_errors');
        return $value;
    }

    private static function test_error_log() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('error_log');
        return $value;
    }

    private static function test_max_char() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('max_char');
        return $value;
    }

    private static function test_default_charset() {
        $value = array();
        $value['compare'] = 'no';
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('default_charset');
        return $value;
    }

    private static function test_output_encoding() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('output_encoding');
        return $value;
    }

    private static function test_memory_limit() {
        $value = array();
        $recomended =  8*1024*1024;
        $current_value = ini_get('memory_limit');
//        if (!$current_value) {
//			$value['message'] = TEST_RESULT_WARN;
//		} 
//                if ($current_value <= $recomended) {
//			$value['message'] = TEST_RESULT_OK;
//		}
//		$value['message'] = TEST_RESULT_NOTICE;
//        
//        $value['Recommended'] = $recomended;
        $value['Current'] = $current_value;
        return $value;
    }

    private static function test_max_input_time() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('max_input_time');
        return $value;
    }

    private static function test_max_execution_time() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('max_execution_time');
        return $value;
    }

    private static function test_max_input_nesting_level() {
        $value = array();
//        $value['Recommended'] = 'http://php.net/manual/en/info.configuration.php#ini.max-input-nesting-level';
        $value['Current'] = self::getIniValue('max_input_nesting_level');
        return $value;
    }
    private static function test_max_input_vars() {
        $value = array();
//        $value['Recommended'] = ' http://php.net/manual/en/info.configuration.php#ini.max-input-vars';
        $value['Current'] = self::getIniValue('max_input_vars');
        return $value;
    }
    private static function test_suhosin_post_max_vars() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('suhosin.post.max_vars');
        return $value;
    }
    private static function test_suhosin_get_max_vars() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('suhosin.get.max_vars');
        return $value;
    }
    private static function test_suhosin_request_max_vars() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('suhosin.request.max_vars');
        return $value;
    }

//self::getIniValue('suhosin.get.max_vars');
//
//self::getIniValue('suhosin.post.max_vars');

    private static function test_open_basedir() {
        $value = array();
        $value['compare'] = 'no';
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('open_basedir');
        return $value;
    }

    private static function test_upload_max_filesize() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('upload_max_filesize');
        return $value;
    }

    private static function test_post_max_size() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('post_max_size');
        return $value;
    }

    private static function test_magic_quotes_gpc() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('magic_quotes_gpc');
        return $value;
    }

    private static function test_output_buffering() {
        $value = array();
        /*$value['Recommended'] = '0'; */
        $value['Current'] = self::getIniValue('output_buffering');
        return $value;
    }

//self::getIniValue('session.cache_expire');
//self::getIniValue('session.save_handler');
//self::getIniValue('session.save_path');

    public static function run($echo = false) {
        

        $methods = get_class_methods('BenchmarkPhp');


        $array = array();
        $total_time = 0;
        foreach ($methods as $method) {
            if (preg_match('/^test_/', $method)) {
                
                $result = self::$method();
                if(isset($result['compare'])){
                unset($result['compare']);
//			$result['message'] ='';
                

                }
//                else{
//                     if (self::getStringValue($result['Recommended']) == self::getStringValue($result['Current'])) {
//                         $result['Recommended'] = self::getStringValue($result['Recommended']);
//                         $result['Current']=self::getStringValue($result['Current']);
//			$result['message'] ='OK';
//                }else{
//                    $result['message'] ='WARNING';
//                }
//                    
//                }
                $return = preg_replace('/test_/', '', $method);
                $array['tests'] [$return] = $result;
            }
        }
        

        return $array;
    }

}
