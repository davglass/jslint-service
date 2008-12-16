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
    file_put_contents($tempName, stripslashes($str));
}


if ($tempName) {
    $cmd = $java.' -jar '.escapeshellarg($rhino).' '.escapeshellarg($jslint).' '.escapeshellarg($fulljslint).' '.escapeshellarg($tempName).' 2>&1'; //This redirects error and out to out so we get it..
    $out = exec($cmd);
    echo($out);
    unlink($tempName);

} else {
    $json->error = new stdclass();
    $json->error->message = 'No javascript to lint.';
    echo(json_encode($json));
}


?>
