<?php
/**
 * proxy of google chart graphviz api
 *
 * $Id proxy.php  tecbbs@qq.com 2015-5-29 $
 **/

$api = "https://chart.googleapis.com/chart?";
//$api = "https://chart.googleapis.com/chart?cht=";
$cht = "gv";
$chl = "graph {fontname=\"SimSun\";node{shape=box];a[label=\"nothing to do~\"];}";
$chof = "gif";

function curlGet($url) {
        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
//        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
        $data = curl_exec ($ch);
        return $data;
}

$url = $api;
$i = 0;
$sum = count($_GET);
foreach($_GET as $k => $v) {
	if($k == "chl" || $k == "chdl") {
		$v = urlencode($v);
	}
	$i++;
	if($i<$sum)
		$url .= $k . "=" . $v . "&";
	else
		$url .= $k . "=" . $v;
		
}
//die($url);
/*
if(isset($_GET['cht'])) {
	$cht = $_GET['cht'];
}
if(isset($_GET['chl'])) {
	$chl = $_GET['chl'];
}
if(isset($_GET['chof'])) {
	$chof = $_GET['chof'];
}
$chl = urlencode($chl);
$url = $api . $cht . "&chl=" . $chl . "&chof=" . $chof;
*/

header("Content-Type: image/webp; charset=UTF-8");
$data = curlGet($url);
die($data);
?>
