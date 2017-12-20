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

$plot = new markdownMindmap("# ab\n## abc", "markdown", "png");
$plot->setIfile();
print_r($plot);
