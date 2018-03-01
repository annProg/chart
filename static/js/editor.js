var form = $("#chart-editor");
var api = form.attr("action") + '?list';
var listdata = {};
$.get(api, function (data,status) {
	$("#listdata").html(data);
	var obj = JSON.parse(data);
	var select = $("#cht");
	Object.keys(obj).forEach(function(key) {
		select.append('<option value="' + key + '">' + obj[key]['desc'] + '</option>');
	});
	select.val("gv");
});
