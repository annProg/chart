<?php
/**
 * test
 **/

$CWD=dirname(__FILE__);
require $CWD . '/../config.php';
spl_autoload_register(function ($class_name) {
	global $CWD;
	require_once $CWD . "/../libs/" . $class_name . '.class.php';
});

$plot = new graphviz("chl", "cht", "chof");
$plot->setIfile();
print_r($plot);
