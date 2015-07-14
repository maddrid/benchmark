<?php
if (!defined('ABS_PATH'))
    exit('Access is not allowed.');
ini_set('xdebug.max_nesting_level',200000);

class BenchClass {
       private static $startTime = 0;
 public static function startTimer() {
        self::$startTime = microtime(true);
    }

    public static function getTimer() {
        return sprintf('%.6f', microtime(true) - self::$startTime);
    }

	private static function test_Math($count = 50000) {
		$time_start = microtime(true);
		$mathFunctions = array("abs", "acos", "asin", "atan", "bindec", "floor", "exp", "sin", "tan", "pi", "is_finite", "is_nan", "sqrt");
		foreach ($mathFunctions as $key => $function) {
			if (!function_exists($function)) unset($mathFunctions[$key]);
		}
		for ($i=0; $i < $count; $i++) {
			foreach ($mathFunctions as $function) {
				$r = call_user_func_array($function, array($i));
			}
		}
		return number_format(microtime(true) - $time_start, 3);
	}
	
	
	private static function test_StringManipulation($count = 50000) {
		$time_start = microtime(true);
		$stringFunctions = array("addslashes", "chunk_split", "metaphone", "strip_tags", "md5", "sha1", "strtoupper", "strtolower", "strrev", "strlen", "soundex", "ord");
		foreach ($stringFunctions as $key => $function) {
			if (!function_exists($function)) unset($stringFunctions[$key]);
		}
		$string = "the quick brown fox jumps over the lazy dog";
		for ($i=0; $i < $count; $i++) {
			foreach ($stringFunctions as $function) {
				$r = call_user_func_array($function, array($string));
			}
		}
		return number_format(microtime(true) - $time_start, 3);
	}


	private static function test_Loops($count = 500000) {
		$time_start = microtime(true);
		for($i = 0; $i < $count; ++$i);
		$i = 0; while($i < $count) ++$i;
		return number_format(microtime(true) - $time_start, 3);
	}

	
	private static function test_IfElse($count = 500000) {
		$time_start = microtime(true);
		for ($i=0; $i < $count; $i++) {
			if ($i == -1) {
			} elseif ($i == -2) {
			} else if ($i == -3) {
			}
		}
		return number_format(microtime(true) - $time_start, 3);
	}	
	
private static function test_simple() {
  $a = 0;
  for ($i = 0; $i < 1000000; $i++) 
    $a++;

  $thisisanotherlongname = 0;
  for ($thisisalongname = 0; $thisisalongname < 1000000; $thisisalongname++) 
    $thisisanotherlongname++;
}

/****/

private static function test_simplecall() {
  for ($i = 0; $i < 1000000; $i++) 
    return strlen("hallo");
}

/****/


private static function test_simpleucall() {
  for ($i = 0; $i < 1000000; $i++) 
    $a ="hallo";
}



/****/

private static function test_mandel() {
  $w1=50;
  $h1=150;
  $recen=-.45;
  $imcen=0.0;
  $r=0.7;
  $s=0;  $rec=0;  $imc=0;  $re=0;  $im=0;  $re2=0;  $im2=0;
  $x=0;  $y=0;  $w2=0;  $h2=0;  $color=0;
  $s=2*$r/$w1;
  $w2=40;
  $h2=12;
  for ($y=0 ; $y<=$w1; $y=$y+1) {
    $imc=$s*($y-$h2)+$imcen;
    for ($x=0 ; $x<=$h1; $x=$x+1) {
      $rec=$s*($x-$w2)+$recen;
      $re=$rec;
      $im=$imc;
      $color=1000;
      $re2=$re*$re;
      $im2=$im*$im;
      while( ((($re2+$im2)<1000000) && $color>0)) {
        $im=$re*$im*2+$imc;
        $re=$re2-$im2+$rec;
        $re2=$re*$re;
        $im2=$im*$im;
        $color=$color-1;
      }
      if ( $color==0 ) {
        return "_";
      } else {
        return "#";
      }
    }
    print "<br>";
    
  }
}

/****/

private static function test_mandel2() {
  $b = " .:,;!/>)|&IH%*#";
  //float r, i, z, Z, t, c, C;
  for ($y=30; printf("\n"), $C = $y*0.1 - 1.5, $y--;){
    for ($x=0; $c = $x*0.04 - 2, $z=0, $Z=0, $x++ < 75;){
      for ($r=$c, $i=$C, $k=0; $t = $z*$z - $Z*$Z + $r, $Z = 2*$z*$Z + $i, $z=$t, $k<5000; $k++)
        if ($z*$z + $Z*$Z > 500000) break;
      return $b[$k%16];
    }
  }
}

/****/

//private static function Ack($m, $n){
//  if($m == 0) return $n+1;
//  if($n == 0) return Ack($m-1, 1);
//  return self::Ack($m - 1, Ack($m, ($n - 1)));
//}
//
//private static function ackermann($n =7) {
//  $r = self::Ack(3,$n);
//  print "Ack(3,$n): $r\n";
//}

/****/

private static function test_ary($n=5000) {
  for ($i=0; $i<$n; $i++) {
    $X[$i] = $i;
  }
  for ($i=$n-1; $i>=0; $i--) {
    $Y[$i] = $X[$i];
  }
  $last = $n-1;
  return "$Y[$last]\n";
}

/****/

private static function test_ary2($n=5000) {
  for ($i=0; $i<$n;) {
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;

    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
    $X[$i] = $i; ++$i;
  }
  for ($i=$n-1; $i>=0;) {
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;

    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
    $Y[$i] = $X[$i]; --$i;
  }
  $last = $n-1;
  return "$Y[$last]\n";
}

/****/

private static function test_ary3($n=2000) {
  for ($i=0; $i<$n; $i++) {
    $X[$i] = $i + 1;
    $Y[$i] = 0;
  }
  for ($k=0; $k<1000; $k++) {
    for ($i=$n-1; $i>=0; $i--) {
      $Y[$i] += $X[$i];
    }
  }
  $last = $n-1;
  return "$Y[0] $Y[$last]\n";
}

/****/

private static function fibo_r($n){
    return(($n < 2) ? 1 : self::fibo_r($n - 2) + self::fibo_r($n - 1));
}

private static function test_fibo($n=30) {
  $r =  self::fibo_r($n);
  return $r;
}

/****/

private static function test_hash1($n=50000) {
  for ($i = 1; $i <= $n; $i++) {
    $X[dechex($i)] = $i;
  }
  $c = 0;
  for ($i = $n; $i > 0; $i--) {
    if ($X[dechex($i)]) { $c++; }
  }
  return $c;
}

/****/

private static function test_hash2($n=5000) {
  for ($i = 0; $i < $n; $i++) {
    $hash1["foo_$i"] = $i;
    $hash2["foo_$i"] = 0;
  }
  for ($i = $n; $i > 0; $i--) {
    foreach($hash1 as $key => $value) $hash2[$key] += $value;
  }
  $first = "foo_0";
  $last  = "foo_".($n-1);
  return "$hash1[$first] $hash1[$last] $hash2[$first] $hash2[$last]\n";
}

/****/

private static function gen_random ($n) {
    global $LAST;
    return( ($n * ($LAST = ($LAST * IA + IC) % IM)) / IM );
}

private static function heapsort_r($n, &$ra) {
    $l = ($n >> 1) + 1;
    $ir = $n;

    while (1) {
	if ($l > 1) {
	    $rra = $ra[--$l];
	} else {
	    $rra = $ra[$ir];
	    $ra[$ir] = $ra[1];
	    if (--$ir == 1) {
		$ra[1] = $rra;
		return;
	    }
	}
	$i = $l;
	$j = $l << 1;
	while ($j <= $ir) {
	    if (($j < $ir) && ($ra[$j] < $ra[$j+1])) {
		$j++;
	    }
	    if ($rra < $ra[$j]) {
		$ra[$i] = $ra[$j];
		$j += ($i = $j);
	    } else {
		$j = $ir + 1;
	    }
	}
	$ra[$i] = $rra;
    }
}

private static function test_heapsort($N=20000) {
  global $LAST;

  define("IM", 139968);
  define("IA", 3877);
  define("IC", 29573);

  $LAST = 42;
  for ($i=1; $i<=$N; $i++) {
    $ary[$i] = self::gen_random(1);
  }
  self::heapsort_r($N, $ary);
  return( $ary[$N]);
}

/****/

 private static function mkmatrix ($rows, $cols) {
    $count = 1;
    $mx = array();
    for ($i=0; $i<$rows; $i++) {
	for ($j=0; $j<$cols; $j++) {
	    $mx[$i][$j] = $count++;
	}
    }
    return($mx);
}

 private static function mmult ($rows, $cols, $m1, $m2) {
    $m3 = array();
    for ($i=0; $i<$rows; $i++) {
	for ($j=0; $j<$cols; $j++) {
	    $x = 0;
	    for ($k=0; $k<$cols; $k++) {
		$x += $m1[$i][$k] * $m2[$k][$j];
	    }
	    $m3[$i][$j] = $x;
	}
    }
    return($m3);
}

private static function test_Matrix($n=20) {
  $SIZE = 30;
  $m1 = self::mkmatrix($SIZE, $SIZE);
  $m2 = self::mkmatrix($SIZE, $SIZE);
  while ($n--) {
    $mm = self::mmult($SIZE, $SIZE, $m1, $m2);
  }
  return "{$mm[0][0]} {$mm[2][3]} {$mm[3][2]} {$mm[4][4]}\n";
}

/****/

private static function test_NestedLoop($n=12) {
  $x = 0;
  for ($a=0; $a<$n; $a++)
    for ($b=0; $b<$n; $b++)
      for ($c=0; $c<$n; $c++)
        for ($d=0; $d<$n; $d++)
          for ($e=0; $e<$n; $e++)
            for ($f=0; $f<$n; $f++)
             $x++;
  return $x;
}

/****/

private static function test_Sieve($n=30) {
  $count = 0;
  while ($n-- > 0) {
    $count = 0;
    $flags = range (0,8192);
    for ($i=2; $i<8193; $i++) {
      if ($flags[$i] > 0) {
        for ($k=$i+$i; $k <= 8192; $k+=$i) {
          $flags[$k] = 0;
        }
        $count++;
      }
    }
  }
  return $count;
}

/****/

private static function test_Strcat($n=200000) {
  $str = "";
  while ($n-- > 0) {
    $str .= "hello\n";
  }
  $len = strlen($str);
  return $len;
}

	public static function run ($echo = false) {
		$total = 0;
		
		$methods = get_class_methods('BenchClass');
		$line = str_pad("-",38,"-");
		
                $array = array();
                $total_time = 0;
		foreach ($methods as $method) {
			if (preg_match('/^test_/', $method)) {
                            self::startTimer();
				$total += $result = self::$method();
                              $time = self::getTimer();   
                              $total_time +=$time ;
				$return = preg_replace('/test_/', '', $method );
                                $array['tests'] [$return] = $time;
			}
		}
                 $array['time'] =$total_time;
		
		return $array;
	}

}




	
?>