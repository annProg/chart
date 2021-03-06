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
	global $config;
	$imgpath = $config['api'] . "?cht=ditaa&chl=" . urlencode($msg);
	$ret = array(
		"errno" => 100,
		"msg" => $msg,
		"imgpath" => $imgpath,
	);
	header('Content-Type:application/json');
	die(json_encode($ret));
}

function _list() {
	global $config;
	$engines = $config['engine'];
	foreach($config['disabled'] as $k => $v) {
		unset($engines[$v]);
	}
	header('Content-Type:application/json');
	die(json_encode($engines));
}

function _check($s) {
	$s = preg_match('/^[a-z0-9]{2,9}$|^$/', $s);
	if($s) return true;
	return false;
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
		if(isset($_GET['cache']))
			$args['cache'] = $_GET['cache'];
	} elseif(isset($_POST['cht']) && isset($_POST['chl'])) {
		$args['cht'] = $_POST['cht'];
		$args['chl'] = $_POST['chl'];
		
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

		if(isset($_POST['cache']))
			$args['cache'] = $_POST['cache'];
	} elseif(isset($_GET['list'])) {
		_list();
	}else {
		error();
	}
	if(!_check($args['chof']) || !_check($args['chs'])) {
		error('invalid char detected');
	}
	if(!array_key_exists($args['cht'], $config['engine']) || in_array($args['cht'], $config['disabled'])) {
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

$imgdomain = $config['rooturl'];
if ($config['cdn'] != "") {
	$imgdomain = $config['cdn'];
}
$ret['imgpath'] = rtrim($imgdomain, '/') . '/' . ltrim($ret['imgpath']);
$ret['codepath'] = rtrim($config['rooturl'], '/') . '/' . ltrim($ret['codepath']);

if($method == "GET" && in_array($ret['imgtype'], array("png", "gif", "jpeg"))) {
	# error.png 缓存时间
	$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
	header("Content-Type: image/$imgtype; charset=UTF-8");

	$maxAge = $config['cache']['age'];
	if ($ret['errno'] != 0) {
		$maxAge = $config['cache']['error'];
	}
	header("Cache-Control: max-age=$maxAge");
	eval($imgstrout);
} elseif($inajax == true) {
	die('<img src="//' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['REQUEST_URI']) . '/' . $ret['imgpath'] . '"/>');
} else {
	header('Content-Type:application/json');
	die(json_encode($ret));
}
