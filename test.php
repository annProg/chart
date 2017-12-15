<!DOCTYPE HTML>
<html>
<head>
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="https://cdn.bootcss.com/ace/1.2.9/ace.js"></script>
<script src="https://cdn.bootcss.com/ace/1.2.9/mode-dot.js"></script>
<script src="https://cdn.bootcss.com/ace/1.2.9/mode-asciidoc.js"></script>
<script src="https://cdn.bootcss.com/ace/1.2.9/theme-github.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
<style type="text/css">
body { 
	width:90%; 
	margin:auto;
	font-size: large;
}
textarea {
	font-family: "Courier New";
}

#content {
	box-shadow: 0 0 5px #BBB;
	height: 650px;
	background: #F7F7F7;
	border: 1px solid #ccc; 
	padding: 30px 100px 60px 10px;
	margin-top: 50px;
}
#editor {
	width: 49%;
	float: left;
}

#ace_editor {
	width: 45%;
	position: absolute;
	height: 500px;
	cursor: text;
	user-select: text;
	box-shadow: 1px 1px 1px 1px #a8b4b9;	
	-webkit-box-shadow: 1px 1px 1px 1px #a8b4b9;	
	-moz-box-shadow: 1px 1px 1px 1px #a8b4b9;
}
#editor #code {
	width: 100%;
	height: 500px;
}
#preview {
	width: 45%;
	margin-left: 20px;
	padding-left: 50px;
	padding-top: 80px;
	float: right;
	text-align: center;
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
$html = '<textarea id="code" name="code">' . $default_code . '</textarea>';
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
<script>
	var input = document.getElementById("code");
	input.style.display="none";
	var aceDiv = document.createElement('div');
	aceDiv.id="ace_editor";
	input.parentElement.parentElement.appendChild(aceDiv);

	var engine = document.getElementById('engine');
	var aceEditor = ace.edit("ace_editor");
	engine.onchange = function () {
		console.log(engine.value);
		if(engine.value == "ditaa") {
			aceEditor.getSession().setMode("ace/mode/asciidoc");
		}else {
			aceEditor.getSession().setMode("ace/mode/dot");
		}

	}
	aceEditor.setTheme("ace/theme/github");
	aceEditor.setValue(input.value);
	aceEditor.setHighlightActiveLine(true);
	aceEditor.getSession().setUseWrapMode(true);
	aceEditor.setFontSize("18px");

	aceEditor.getSession().on("change", function(e) {
		input.value = aceEditor.getValue();
	});
</script>
</body>
</html>
