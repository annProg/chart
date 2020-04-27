var form = $("#chart-editor");
var api = form.attr("action") + '?list';
//var listdata = {};
$.get(api, function (data,status) {
	//$("#listdata").html(data);
	var select = $("#cht");
	Object.keys(data).forEach(function(key) {
		select.append('<option value="' + key + '">' + data[key]['desc'] + '</option>');
	});
	select.val("gv");
});

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
	$("#" + id).attr('src', 'static/error.png');
}	

