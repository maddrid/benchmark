<?php

define('ABS_PATH', dirname(dirname(dirname(dirname(__FILE__)))) . '/');
define('OC_ADMIN', true);
require_once ABS_PATH . 'oc-load.php';
set_time_limit(300);
if (!osc_is_admin_user_logged_in()) {
    die('CHEATING ?');
}

function benchmarkInfo2File($etest, $target_file) {

    switch ($etest) {
        case 'serverinfo':
            ob_start();
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
	
}
            $info = ob_get_contents();
            ob_end_clean();

            benchmarkCreatePdf($info, $target_file);
            break;
        case 'dbinfo':
            ob_start();
            include (BENCHMARK_PATH . 'info/info_db.php');
            $info = ob_get_contents();
            ob_end_clean();
            benchmarkCreatePdf($info, $target_file);

            break;
        case 'phpinfo':
            ob_start();
            @phpinfo();
            $info = ob_get_contents();
            ob_end_clean();
            $info2 = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $info);
            benchmarkCreatePdf($info2, $target_file);
            break;
        case 'phpfunctions':

            ob_start();
            $functions = get_defined_functions();

            $sistem_functions = array();

            $country = 'us';
            foreach ($functions['internal'] as $key => $value) {
                $sistem_functions[] = $value;
            }
        sort($sistem_functions);
           debug_var($sistem_functions, 'Sistem Functions');
           
            $info = ob_get_contents();
            ob_end_clean();

            benchmarkCreatePdf($info, $target_file);
            break;
        case 'oscfunctions':
            ob_start();
            include (BENCHMARK_PATH . 'info/info_oscfunctions.php');
            $info = ob_get_contents();
            ob_end_clean();

            benchmarkCreatePdf($info, $target_file);
            break;
        case 'test':
            ob_start();
            include (BENCHMARK_PATH . 'info/info_test.php');
            $info = ob_get_contents();
            ob_end_clean();

            benchmarkCreatePdf($info, $target_file);
            break;

        default: bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/help.php'));

            break;
    }
}

function benchmarkCreatePdf($info, $file_name) {


    require_once('tcpdf/tcpdf.php');

// create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Web-Media');
    $pdf->SetTitle('Benchmark (Osclass) plugin export');
    $pdf->SetSubject('Benchmark Info');
    $pdf->SetKeywords('benchmark, PDF, example, info, guide');

    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
// set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


// set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
    if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
        require_once(dirname(__FILE__) . '/lang/eng.php');
        $pdf->setLanguageArray($l);
    }



    $pdf->SetFont('times', 'BI', 8);

    $pdf->AddPage();


    // Print text using writeHTMLCell()
    $pdf->writeHTML($info, true, false, true, false, '');

    $pdf->Output(BENCHMARK_EMAILS_PATH . $file_name . '.pdf', 'F');
}

function benchmarkForceDownload($file_name) {
    if (is_file($file_name)) {
// required for IE
        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }


//        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
//            case 'pdf': $mime = 'application/pdf';
//                break;
//            case 'zip': $mime = 'application/zip';
//                break;
//            case 'jpeg':
//            case 'jpg': $mime = 'image/jpg';
//                break;
//            default: $mime = 'application/force-download';
//        }
        $mime = 'application/force-download';
        header('Pragma: public');  // required
        header('Expires: 0');  // no cache
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($file_name)) . ' GMT');
        header('Cache-Control: private', false);
        header('Content-Type: ' . $mime);
        header('Content-Disposition: attachment; filename="' . basename($file_name) . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file_name)); // provide file size
        header('Connection: close');

        readfile($file_name);  // push it out
        @unlink($file_name);
        
    } else {
        osc_add_flash_error_message($file_name . ' cannot be created', 'admin');
        bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/save.php'));
    }
}

//osc_sendMail($params);

$options = benchmark_send_options();
$etest = Params::getParam('eTest');
switch (Params::getParam('benchmark_action')) {
    case 'save_file':
        if (array_key_exists($etest, $options)) {

            benchmarkInfo2File($etest, $etest);
            $file_name = BENCHMARK_EMAILS_PATH . $etest;

            benchmarkForceDownload($file_name . '.pdf');
            bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/save.php'));
        } else {
            osc_add_flash_error_message('No Info to save selected', 'admin');
            bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/save.php'));
        }
        break;
    case'send_email':
	osc_add_flash_error_message('Not available yet', 'admin');
     bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/email.php'));

        break;
    default : bench_js_redirect_to(osc_admin_render_plugin_url('benchmark/help.php'));
}    