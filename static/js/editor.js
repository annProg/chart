var form = $("#chart-editor");
var api = form.attr("action") + '?list';
var listdata = {};
$.get(api, function (data,status) {
	$("#listdata").html(data);
	var select = $("#cht");
	Object.keys(data).forEach(function(key) {
		select.append('<option value="' + key + '">' + data[key]['desc'] + '</option>');
	});
	select.val("gv");
});
