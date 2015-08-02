<?php
/**
 * graphviz api
 *
 * $Id api.php  tecbbs@qq.com 2015-6-8 $
 **/

$config = array();
$config['engine'] = array("gv","gv:dot", "gv:neato", "gv:fdp", "gv:sfdp", "gv:twopi", "gv:circo", "gp");
$config['imgtype'] = array("png", "gif", "jpeg");
$config['out']['code'] = "./code/";
$config['out']['img'] = "./img/";
foreach ( $config['out'] as $v ) {
	if(!file_exists($v)) {
		mkdir($v, 0755);
	} 
}
if(isset($_SERVER['HTTP_HOST'])) {
	$config['host'] = $_SERVER['HTTP_HOST'];
}
else {
	$config['host'] = "localhost";
}
$config['siteurl'] = "http://" . $config['host'] . "/gv/";
$config['error'] = "error.png";


function error() {
	die("args error! nothing to do...");
}

function get_args() {
	$ret = array();
	global $config;
	if(isset($_GET['cht']) && isset($_GET['chl'])) {
		$ret['cht'] = $_GET['cht'];
		$ret['chl'] = $_GET['chl'];
		if(isset($_GET['chof']))
			$ret['imgtype'] = $_GET['chof'];
		else
			$ret['imgtype'] = "png";
	} elseif(isset($_POST['cht']) && isset($_POST['chl'])) {
		$ret['cht'] = $_POST['cht'];
		$ret['chl'] = urldecode($_POST['chl']);
		
		if(isset($_POST['chof']))
			$ret['imgtype'] = $_POST['chof'];
		else
			$ret['imgtype'] = "png";
	} else {
		error();
	}
	if(!in_array($ret['cht'], $config['engine'])) {
		error();
	}
	if(!in_array($ret['imgtype'], $config['imgtype'])) {
		$ret['imgtype'] = "png";
	}
	$name = md5($ret['chl']) . ":" . $ret['cht'];
	$ret['out']['code'] = $config['out']['code'] . $name;
	$ret['out']['img'] = $config['out']['img'] . $name . "." . $ret['imgtype'];
	return $ret;
}

function write_code($arr) {
	$filepath = $arr['out']['code'];
	$chl = $arr['chl'];

	$file = fopen("$filepath", "w");
	$encode = mb_detect_encoding($chl, array("ASCII","UTF-8","GB2312", "GBK", "EUC-CN"));

	if($encode != "UTF-8") { 
		$chl = iconv("$encode", "UTF-8", $chl);
	}

	$chl = str_replace("&gt;", ">", $chl);
	$chl = str_replace("&lt;", "<", $chl);
	$chl = str_replace("&quot;", "\"", $chl);
	fwrite($file, "$chl");
	fclose($file);
}

function graphviz($arr) {
	$ret = array();
	$imgpath = $arr['out']['img'];
	$imgtype = $arr['imgtype'];

	$gvpath = $arr['out']['code'];
	$engine = $arr['engine'];
	global $config;
	
	$ret['imgpath'] = $imgpath;
	$ret['imgtype'] = $imgtype;

	if(!file_exists($imgpath)) {
		exec("$engine -T$imgtype $gvpath -o $imgpath", $out, $res);
		if($res != 0) {
			$ret['imgpath'] = $config['error'];
			$ret['imgtype'] = "png";
		}
	}
	
	return $ret;
}

function gnuplot($arr) {
	$ret = array();
	$imgpath = $arr['out']['img'];
	$imgtype = $arr['imgtype'];

	$codepath = $arr['out']['code'];
	$engine = $arr['engine'];
	global $config;

	$ret['imgpath'] = $imgpath;
	$ret['imgtype'] = $imgtype;

	if(!file_exists($imgpath)) {
		exec("$engine -e \"set term png;set output '$imgpath'\" $codepath", $out, $res);
		if($res != 0) {
			$ret['imgpath'] = $config['error'];
			$ret['imgtype'] = "png";
		}
	}
	return $ret;
}

$api = get_args();
write_code($api);

$arr = explode(':', $api['cht']);
switch ($arr[0]) {
	case "gv":
		if(array_key_exists("1", $arr)) {
			$api['engine'] = $arr[1];
		} else {
			$api['engine'] = "dot";
		}
		$plot = graphviz($api);break;
	case "gp":
		$api['engine'] = "gnuplot";
		$plot = gnuplot($api);break;
	defualt:
		error();
}

$imgtype = $plot['imgtype'];
$imgpath = $plot['imgpath'];

$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
if(isset($_GET['cht']) && isset($_GET['chl'])) {
	header("Content-Type: image/$imgtype; charset=UTF-8");
	eval($imgstrout);
}
?>
