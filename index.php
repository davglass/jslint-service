<?php

$str = '';
$java = `which java`;
$java = 'java';
$dir = realpath('./');
$jslint = $dir.'/lib/jslint/jslint-console.js';
$fulljslint = $dir.'/lib/jslint/fulljslint.js';
$rhino = $dir.'/lib/rhino/js.jar';


$json = new stdclass();

if ($_POST['source']) {
    $str = $_POST['source'];
    $tempName = tempnam(sys_get_temp_dir(), 'jslint-');
    $tempNameOut = tempnam(sys_get_temp_dir(), 'jslint-');
    file_put_contents($tempName, stripslashes($str));
    chmod($tempName, 0755);
}


if ($tempName) {
    $cmd = $java.' -jar '.escapeshellarg($rhino).' '.escapeshellarg($jslint).' '.$fulljslint.' '.escapeshellarg($tempName).' 2>&1';
    //echo($cmd);
    $out = exec($cmd, $data);
    
    $error = file_get_contents($tempNameOut);
    $error = str_replace('js: ', '', $error);
    $error = str_replace('"'.$tempName.'", ', '', $error);

    //echo('<pre>'.$error.'</pre>');
    echo($out);
    //echo('<pre>'.print_r($data, 1).'</pre>');

} else {
    $json->error = new stdclass();
    $json->error->message = 'No javascript to lint.';
    echo(json_encode($json));
}


?>
