<?php
/**
 * plot api
 *
 * $Id api.php  tecbbs@qq.com 2015-6-8 $
 **/

require "config.php";
require "./libs/plot.class.php";

// -- LOAD classes //
$files = array_filter(scandir(__DIR__ . '/./libs'), function ($item) {
	return preg_match('/.*\.class\.php/', $item) && (!preg_match('/^plot\.class\.php/', $item));
});
foreach($files as $k => $v) {
	require_once "./libs/" . $v;
}

function error($msg = "args error") {
	$ret = array(
		"errno" => 100,
		"msg" => $msg,
	);
	die(json_encode($ret));
}

function _list() {
	global $config;
	die(json_encode($config['engine']));
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
		if(isset($_GET['chs']))
			$args['chs'] = $_GET['chs'];
		else
			$args['chs'] = "";
	} elseif(isset($_POST['cht']) && isset($_POST['chl'])) {
		$args['cht'] = $_POST['cht'];
		$args['chl'] = urldecode($_POST['chl']);
		
		$method = "POST";
		if(isset($_POST['chof']))
			$args['chof'] = $_POST['chof'];
		else
			$args['chof'] = "png";

		if(isset($_POST['chs']))
			$args['chs'] = $_POST['chs'];
		else
			$args['chs'] = "";
		if(isset($_POST['inajax']) && $_POST['inajax'] == 1) {
			global $inajax;
			$inajax = true;
		}
	} elseif(isset($_GET['list'])) {
		_list();
	}else {
		error();
	}
	if(!array_key_exists($args['cht'], $config['engine'])) {
		error("invalid cht:" . $args['cht']);
	}
	return $args;
}

$args = get_args();
$cht = explode(':', $args['cht']);
$class = $config['engine'][$cht[0]]['class'];
$expr = "\$plot = new $class(\$args);";
eval($expr);

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

if($method == "GET" && in_array($ret['imgtype'], array("png", "gif", "jpeg"))) {
	$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
	header("Content-Type: image/$imgtype; charset=UTF-8");
	eval($imgstrout);
} elseif($inajax == true) {
	die('<img src="//' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/' . $ret['imgpath'] . '"/>');
} else {
	die(json_encode($ret));
}
