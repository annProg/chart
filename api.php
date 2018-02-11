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
$inajax = false;
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

		if(isset($_POST['inajax']) && $_POST['inajax'] == 1) {
			global $inajax;
			$inajax = true;
		}
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
	case "radar":
		$plot = new radar($args['chl'], $args['cht'], $args['chof'], $config['node_path']);break;
	defualt:
		error();
}

$ret = $plot->render();
if($ret['errno'] != 0) {
	$imgpath = $config['error'];
	$imgtype = "png";	
	$ret['imgpath'] = $imgpath;
} else {
	$imgtype = $ret['imgtype'];
	$imgpath = $ret['imgpath'];
}

$ret['imgpath'] = rtrim($config['rooturl'], '/') . '/' . ltrim($ret['imgpath']);
$ret['codepath'] = rtrim($config['rooturl'], '/') . '/' . ltrim($ret['codepath']);

if($method == "GET" && in_array($ret['imgtype'], $config['imgtype'])) {
	$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
	header("Content-Type: image/$imgtype; charset=UTF-8");
	eval($imgstrout);
} elseif($inajax == true) {
	die('<img src="//' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/' . $ret['imgpath'] . '"/>');
} else {
	die(json_encode($ret));
}
