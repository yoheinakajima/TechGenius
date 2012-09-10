<?php 
$results = array("key" => "value");
echo $_GET['callback'] . '(' . json_encode($results) . ')';
?>