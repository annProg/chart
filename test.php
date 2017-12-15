<!DOCTYPE HTML>
<html>
<head>
<link href="//cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" media="screen">
<script src="//cdn.bootcss.com/ace/1.2.9/ace.js"></script>
<script src="//cdn.bootcss.com/ace/1.2.9/mode-dot.js"></script>
<script src="//cdn.bootcss.com/ace/1.2.9/mode-markdown.js"></script>
<script src="//cdn.bootcss.com/ace/1.2.9/mode-asciidoc.js"></script>
<script src="//cdn.bootcss.com/ace/1.2.9/theme-github.js"></script>
<script src="//cdn.bootcss.com/marked/0.3.7/marked.min.js"></script>
<script src="//cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" charset="utf-8">
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

#show-dot-code {
	text-align: left;
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
$default_dot = "";
$selected = "gv";
if(isset($_GET['code']))
{
	$default_code = $_GET['code'];
}
if(isset($_GET['markdown-dot']))
{
	$default_dot = $_GET['markdown-dot'];
}
if(isset($_GET['engine']))
{
	$selected = $_GET['engine'];
}

$engines = $config['engine'];
$html = '<textarea id="code" name="code">' . $default_code . '</textarea>';
$html .= '<textarea id="markdown-dot" name="markdown-dot" style="display:none">' . $default_dot . '</textarea>';
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
	$engine = $_GET['engine'];
	$code = urlencode($_GET['code']);
	$markdownDot = "";
	if($engine == "markdown") {
		$engine = "gv:dot";
		$code = urlencode($_GET['markdown-dot']);
		$markdownDot = '<p id="tog" onclick="togClick();">查看dot源码</p>';
	}
	$api = $config['api'] . "?cht=" . $engine . "&chl=";
	print("<div id=\"preview\"><img src=\"$api$code\" />$markdownDot</div>");
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
	var engineName = engine.value;
	var aceEditor = ace.edit("ace_editor");
	engine.onchange = function () {
		if(engine.value == "ditaa") {
			aceEditor.getSession().setMode("ace/mode/asciidoc");
		} else if(engine.value == "markdown") {
			aceEditor.getSession().setMode("ace/mode/markdown");
		}else {
			aceEditor.getSession().setMode("ace/mode/dot");
		}
		engineName = engine.value;
	}
	aceEditor.setTheme("ace/theme/github");
	aceEditor.setValue(input.value);
	aceEditor.setHighlightActiveLine(true);
	aceEditor.getSession().setUseWrapMode(true);
	aceEditor.setFontSize("18px");

	var showdot = document.createElement('div');
	showdot.id = 'show-dot-code';
	showdot.style.display = 'none';
	document.getElementById('preview').appendChild(showdot);
	$('#show-dot-code').html('<pre>' + markdown2dot(aceEditor.getValue()) + '</pre>');

	aceEditor.getSession().on("change", function(e) {
		input.value = aceEditor.getValue();
		if(engineName == "markdown") {
			dotcode = markdown2dot(aceEditor.getValue());
			$("#markdown-dot").val(dotcode);
			$('#show-dot-code').html('<pre>' + dotcode + '</pre>');
		}
	});

	function markdown2dot(markdown) {
		marked.setOptions({
			sanitize: true,
			breaks: true
		});
		html = marked(markdown);
		html = $(html);
		nodes = new Array();
		edges = new Array();
		id = 0;

		colorbase = new Array("tomato", "yellow", "whitesmoke", "yellowgreen", "skyblue", "mintcream");
		colors = new Array(colorbase.sort(), colorbase, colorbase.reverse(), colorbase, colorbase, colorbase);
		html.each(function() {
			var tagName = $(this).get(0).tagName;
			var label = $(this).text().replace(/\r?\n/, '');
			var node = tagName + "_" + id;
			var level = 0;
			shape = "box";
			switch(tagName) {
				case "H1": level = 1;color = "tomato"; shape = "ellipse";break;
				case "H2": level = 2;color = "yellow";break;
				case "H3": level = 3;color = "lightblue2";break;
				case "H4": level = 4;color = "whitesmoke";break;
				case "H5": level = 5;color = "yellowgreen";break;
				case "H6": level = 6;color = "skyblue";break;
				default: color = "mintcream";
			}
			expectTag = "H" + (level-1);
			var prev = "";
			item = $(this);
			newid = id;
			while(true) {
				var prevItem = item.prev().get(0);
				if(!prevItem) {break;}
				newid--;
				var prevTag = prevItem.tagName;
				if(prevTag == expectTag) {
					prev = expectTag + "_" + newid;
					break;
				}
				item = item.prev();
			}

			if(level > 1) {
				color = colors[level%colors.length][newid%colorbase.length];
			}
			if(label) {
				id++;
				nodes.push('"' + node + '"[color="' + color + '",label="' + label + '",fillcolor="' + color + '", style="filled", shape="' + shape + '"];');
			}
			if(prev) {
				edges.push('"' + prev + '" -> "' + node + '";');	
			}
		});
		var dot = 'digraph G{rankdir="LR";\n' + nodes.join('\n') + '\n' + edges.join('\n') + '\n}';		
		return(dot);
	}

	function togClick() {
		var tog = document.getElementById('tog');
		var showdot = document.getElementById('show-dot-code');
		if(showdot.style.display == "none") {
			showdot.style.display = "block";
			tog.innerText = "隐藏dot源码";
		} else {
			showdot.style.display = "none";
			tog.innerText = "显示dot源码";
		}
	
	}
</script>
</body>
</html>
