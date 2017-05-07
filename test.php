<!DOCTYPE HTML>
<html>
<head>
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<style type="text/css">
body { 
	width:90%; 
	margin:auto;
	font-size: large;
}
#content {
	box-shadow: 0 0 5px #BBB;
	height: 1000px;
	background: #F7F7F7;
	border: 1px solid #ccc; 
	padding: 30px 100px 60px 10px;
	margin-top: 50px;
}
#editor {
	width: 45%;
	float: left;
}
#preview {
	width: 45%;
	float: right;
}
</style>
<title>Chart Api Test Tool</title>
</head>
<body>
<div id="content">
<div id="editor">
<form method="GET" role="form" class="form-horizontal">
<?php
require 'config.php';
/**
 * Usage:
 * File Name: test.php
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-05-04 17:04:52
 **/
$default_code = "";
$selected = "gv";
if(isset($_GET['code']))
{
	$default_code = $_GET['code'];
}
if(isset($_GET['engine']))
{
	$selected = $_GET['engine'];
}

$engines = $config['engine'];
$html = '<textarea id="code" name="code" cols="100" rows="20">' . $default_code . '</textarea>';
$html .= '<br>';
$html .= '<select id="engine" name="engine">';

foreach($engines as $k => $v)
{
	if($k == $selected)
	{
		$html .= '<option value="' . $k . '" selected="selected">' . $v . '</option>';
	}else {
		$html .= '<option value="' . $k . '">' . $v . '</option>';
	}
}
$html .= '</select>';
$html .= '<button id="submit" name="submit" value="Submit">Submit</button>';
$html .= '</form></div>';

print_r($html);

if(isset($_GET['submit']))
{
	$api = $config['api'] . "?cht=" . $_GET['engine'] . "&chl=";
	$code = urlencode($_GET['code']);
	print("<div id=\"preview\"><img src=\"$api$code\" /></div>");
}
?>
</div>
</body>
</html>
