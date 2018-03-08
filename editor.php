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
	height: 600px;
	margin-left: 20px;
	padding-left: 50px;
	padding-top: 60px;
	float: right;
	text-align: center;
}

#preview img {
	max-width: 100%;
	max-height: 90%;
}

#show-dot-code {
	width: 100%;
	text-align: left;
	display: none;
}
</style>
<title>Chart Api Test Tool</title>
</head>
<body>

<div id="content">
<div id="listdata" style="display:none"></div>
<div id="editor">
<form id="chart-editor" accept-charset="utf-8" name="editor" method="POST" action="
<?php require 'config.php';
echo $config['api'];?>
" enctype="application/x-www-form-urlencoded">
	<textarea name="chl" id="chl"></textarea>
	<br>
	<select id="cht" name="cht"></select>
	<label for="chof">Output Format:&nbsp;</label>
	<input type="" name="chof" value="" id="chof" size=5 placeholder="png">
	<input type="button" id="submit" name="submit" value="Submit" onclick=preview();>
</form>
</div>
<div style="text-align:center; margin:0 auto;" id="preview">
	<img id="imgpreview" style="max-width:95%;" src="error.png" alt="chart" title="chart"/>
</div>
</div>
<script>
	var input = document.getElementById("chl");
	input.style.display="none";
	var aceDiv = document.createElement('div');
	aceDiv.id="ace_editor";
	input.parentElement.parentElement.appendChild(aceDiv);

	var engine = document.getElementById('cht');
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

	aceEditor.getSession().on("change", function(e) {
		input.value = aceEditor.getValue();
	});

	function zxsq_ajaxpost(formid, recall) {
		var request;
		if(window.XMLHttpRequest) {
			request = new XMLHttpRequest();
		} else if ( window.ActiveXObject) {
			request = new ActiveXObject("Microsoft.XMLHTTP");
		} else {
			return;
		}

		request.onreadystatechange = function() {recall(request, formid);};

		var sendData = new FormData($("#" + formid)[0]);


		request.open('POST', $("#" + formid).attr('action'), true);
		request.send(sendData);
	}
		
	function preview() {
		var zxsq_mindmap_forms = document.querySelectorAll('#editor form');
		for(var i=0;i<zxsq_mindmap_forms.length;i++) {
			var cur_form = zxsq_mindmap_forms[i];
			var formid = cur_form.id;
			var textarea = cur_form.querySelector('textarea');
			var oldcode = textarea.value;
			textarea.defaultValue = oldcode.replace(/<br \/>\n/g, '\n');

			zxsq_ajaxpost(formid, showMindMap);
		}
	}

	function showMindMap(request, formid) {
		var imgid = 'imgpreview';
		if (request.readyState == 4) {
			if(request.status == 200) {
				try {
					var res = JSON.parse(request.responseText);
					$("#" + imgid).attr('src', res['imgpath']);
					return true;
				} catch(e) {
					onError(imgid);
				}
			} else {
				onError(imgid);
			}
		}
	}

	function onError(id) {
		$("#" + id).attr('src', 'error.png');
	}	
</script>
<script src="static/js/editor.js"></script>
</body>
</html>
