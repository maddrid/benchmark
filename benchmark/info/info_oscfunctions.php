<?php if (!defined('ABS_PATH'))
    exit('Access is not allowed.');



?>


<?php
// ALL USER DEFINED FUNCTIONS
$functions = get_defined_functions();



$functions_list = array();
foreach ($functions['user'] as $func) {
        $f = new ReflectionFunction($func);
        $args = array();
        foreach ($f->getParameters() as $param) {
                $tmparg = '';
                if ($param->isPassedByReference()) $tmparg = '&';
                if ($param->isOptional()) {
                        $tmparg = '[' . $tmparg . '$' . $param->getName() . ' = ' . $param->getDefaultValue() . ']';
                } else {
                        $tmparg.= '&' . $param->getName();
                }
                $args[] = $tmparg;
                unset ($tmparg);
        }
        $functions_list[] =  $func . ' ( ' . implode(', ', $args) . ' )' . PHP_EOL;
}

debug_var($functions_list, 'Osclass available (core & plugins) Functions');


// ALL INTERNAL FUNCTIONS
?>


