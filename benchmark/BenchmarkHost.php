<?php

if (!defined('ABS_PATH'))
    exit('ABS_PATH is not loaded. Direct access is not allowed.');
require 'BenchmarkItem.php';

class BenchmarkHost {

    private static $startTime = 0;
    private static $lipsum = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

    public static function startTimer() {
        self::$startTime = microtime(true);
    }

    public static function getTimer() {
        return sprintf('%.4f', microtime(true) - self::$startTime);
    }

    public static function bench_cpu() {
        self::startTimer();
        //Calls bcfact() 12753 times for 700 digits of PI
        $pi = self::makePI(); //Consider this 12753 operations.
        $catString = "The quick brown fox jumps over the lazy dog. The other quick brown fox also jumped over the other lazy dog. ";
        $bigString = "";
        $dir = 'forward';
        for ($i = 0; $i < 3000; $i++) { //Consider this 10000 operations
            if ($dir == 'forward') {
                $bigString .= $catString;
            } else {
                $bigString = substr($bigString, strlen($catString));
            }
            if (strlen($bigString) > 500000) {
                $dir = 'back';
            } else if (strlen($bigString) == 0) {
                $dir = 'forward';
            }
        }
        $time = self::getTimer();
        $totalOps = 3000 + 1000000; //ops for pi and ops for concat loop. This is very very arbitrary, but lets us compare apples with apples.
        $bogoWips = sprintf('%.0f', $totalOps / $time);
        $speed = number_format($bogoWips, 0, '.', ',') . ' Loops';
        $array = array();
        $array['time'] = $time;
        $array['speed'] = $speed;
        return $array;
    }

    public static function bench_networkspeed() {
        self::startTimer();

        $data = osc_file_get_contents('http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.js');
        $data .= osc_file_get_contents('http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.js');
        $data .= osc_file_get_contents('http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.js');
        $time = self::getTimer();
        $bytes = strlen($data);
        $mbps = sprintf('%.2f', $bytes * 8 / 1024 / 1024 / $time);
        $speed = number_format($mbps, 2, '.', ',') . ' Mbps';

        $array = array();
        $array['time'] = $time;
        $array['speed'] = $speed;

        return $array;
    }

    public static function bench_database() {

        return BenchmarkModel::newInstance()->bench_database();
    }

    public static function bench_file_create($files = 1000) {

        $time = microtime(true);
        for ($i = 0; $i < $files; $i++) {
            $file = @fopen(BENCHMARK_PATH . "/test_time/test_file_$i", 'wb');
            @fwrite($file, '<?php #Hello, test! ?>');
            @fclose($file);
            if (file_exists("{$_SERVER['DOCUMENT_ROOT']}/test_time/test_file_$i") == false) {
                continue;
            }
        }

        $result =   microtime(true)-$time;

        if (file_exists(BENCHMARK_PATH . "/test_time")) {
            for ($i = 0; $i < $files; $i++) {
                @unlink(BENCHMARK_PATH . "/test_time/test_file_$i");
            }
        }

        return array('time'=>$result);
    }

    public static function bench_item() {
        self::startTimer();
        $dummy_item = new BenchmarkItem ();
        $success = $dummy_item->dummyItem();
        if ($success != 1 && $success != 2) {
            $message = ' Something went wrong Item not inserted';
        } else {
            $itemId = Params::getParam('itemId');
            $message = $itemId;
        }
        $time = self::getTimer();
        $array = array();
        $array['time'] = $time;
        $array['message'] = $message;

        return $array;
    }

    public static function makePI() {
        $a = 0;
        $b = 0;
        for ($i = 0; $i < 10000000; $i++) {
            $a += $i;
            $b += $a;
        }
    }

}

?>
