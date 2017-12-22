<?php
/**
 * plot api
 *
 * $Id api.php  tecbbs@qq.com 2015-6-8 $
 **/

require 'config.php';
spl_autoload_register(function ($class_name) {
	require_once "./libs/" . $class_name . '.class.php';
});

function error() {
	die("args error! nothing to do...");
}

$method = "GET";
function get_args() {
	global $config;
	global $method;
	$args = array();
	if(isset($_GET['cht']) && isset($_GET['chl'])) {
		$args['cht'] = $_GET['cht'];
		$args['chl'] = $_GET['chl'];
		if(isset($_GET['chof']))
			$args['chof'] = $_GET['chof'];
		else
			$args['chof'] = "png";
	} elseif(isset($_POST['cht']) && isset($_POST['chl'])) {
		$args['cht'] = $_POST['cht'];
		$args['chl'] = urldecode($_POST['chl']);
		
		$method = "POST";
		if(isset($_POST['chof']))
			$args['chof'] = $_POST['chof'];
		else
			$args['chof'] = "png";
	} else {
		error();
	}

	if(!array_key_exists($args['cht'], $config['engine'])) {
		error();
	}
	return $args;
}

$args = get_args();
$cht = explode(':', $args['cht']);

switch ($cht[0]) {
	case "gv":
		$plot = new graphviz($args['chl'], $args['cht'], $args['chof']);break;
	case "ditaa":
		$plot = new ditaa($args['chl'], $args['cht'], $args['chof']);break;
	case "gp":
		$plot = new gnuplot($args['chl'], $args['cht'], $args['chof']);break;
	case "gnuplot":
		$plot = new gnuplot($args['chl'], $args['cht'], $args['chof']);break;
	case "markdown":
		$plot = new markdownMindmap($args['chl'], $args['cht'], $args['chof']);break;
	case "blockdiag":
		$plot = new blockdiag($args['chl'], $args['cht'], $args['chof']);break;
	defualt:
		error();
}

$ret = $plot->render();
if($ret['errno'] != 0 && $method == "GET") {
	$imgpath = $config['error'];
	$imgtype = "png";	
} else {
	$imgtype = $ret['imgtype'];
	$imgpath = $ret['imgpath'];
}

if($method == "GET" && in_array($ret['imgtype'], $config['imgtype'])) {
	$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
	header("Content-Type: image/$imgtype; charset=UTF-8");
	eval($imgstrout);
} else {
	die(json_encode($ret));
}
