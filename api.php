<?php
/**
 * graphviz api
 *
 * $Id api.php  tecbbs@qq.com 2015-6-8 $
 **/
$host = $_SERVER['HTTP_HOST'];
$siteurl = "http://" . $host . "/gv/"; 
$cht = "gv:dot";
$chl = "graph {fontname=\"SimSun\";node[shape=box];a[label=\"nothing to do~ 参数错误\"];}";
$error = "error.png";
$engine = array("dot", "neato", "fdp", "sfdp", "twopi", "circo");
$imgtype = "png"; 
$imgtype_arr = array("png", "gif", "jpeg");

if(isset($_GET['cht']) && isset($_GET['chl']) && isset($_GET['chof'])) {
	$cht = $_GET['cht'];
	$chl = $_GET['chl'];
	$imgtype = $_GET['chof'];
} elseif(isset($_POST['cht']) && isset($_POST['chl']) && isset($_POST['chof'])) {
	$cht = $_POST['cht'];
	$chl = urldecode($_POST['chl']);
	$imgtype = $_POST['chof'];
} else {
	die("args error! nothing to do...");
}
 
$arr = explode(':', $cht);
if(!array_key_exists("1", $arr)) {
	$cht = "dot";
} else {
	$cht = $arr['1'];
}
if(!in_array($cht, $engine)) {
	$cht = "dot";
}

if(!in_array($imgtype, $imgtype_arr)) {
	$imgtype = "png";
}

$gvname = md5($chl) . $cht;
$gvpath = "./gv/" . $gvname . ".gv";
$imgpath = "img/" . $gvname . "." .  $imgtype;


$file = fopen("$gvpath", "w");
$encode = mb_detect_encoding($chl, array("ASCII","UTF-8","GB2312", "GBK", "EUC-CN"));

if($encode != "UTF-8") { 
	$chl = iconv("$encode", "UTF-8", $chl);
}

$chl = str_replace("&gt;", ">", $chl);
$chl = str_replace("&lt;", "<", $chl);
$chl = str_replace("&quot;", "\"", $chl);
fwrite($file, "$chl");
fclose($file);
if(!file_exists($imgpath)) {
	exec("$cht -T$imgtype $gvpath -o $imgpath",$out, $ret);
	if($ret != 0) {
		$imgpath = $error;		
		$imgtype = "png";
	}
}

$imgstrout = "image$imgtype(imagecreatefrom$imgtype('$imgpath'));";
if(isset($_GET['cht']) && isset($_GET['chl'])) {
	header("Content-Type: image/$imgtype; charset=UTF-8");
	eval($imgstrout);
}
?>
