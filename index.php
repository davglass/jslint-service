<?php

$str = '';
$java = `which java`;
$dir = realpath('./');
$jslint = $dir.'/lib/jslint/jslint-console.js';
//$jslint = $dir.'/lib/jslint/fulljslint.js';
$rhino = $dir.'/lib/rhino/js.jar';


$json = new stdclass();

if ($_POST['source']) {
    $str = $_POST['source'];
    $tempName = tempnam(sys_get_temp_dir(), 'jslint-');
    file_put_contents($tempName, stripslashes($str));
    chmod($tempName, 0755);
}


if ($tempName) {
    $cmd = $java.' -jar '.escapeshellarg($rhino).' '.escapeshellarg($jslint).' '.escapeshellarg($tempName);
    echo($cmd);
    //$out = exec($cmd, $data);
    $out = shell_exec($cmd);

    echo('<pre>'.print_r($out, 1).'</pre>');
    echo('<pre>'.print_r($data, 1).'</pre>');
} else {
    $json->error = new stdclass();
    $json->error->message = 'No javascript to lint.';
}


echo(json_encode($json));
?>
