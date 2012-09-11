<?php 
header('Content-type: application/json');
$results = array("key" => "value");
finish();

function finish() {
    header("content-type:application/json");
    if ($_GET['callback']) {
        print $_GET['callback']."(";
    }
    print json_encode($GLOBALS['results']);
    if ($_GET['callback']) {
        print ")";
    }
    exit; 
}
?>