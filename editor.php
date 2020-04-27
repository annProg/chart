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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/github-fork-ribbon-css/0.2.3/gh-fork-ribbon.min.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no" charset="utf-8">
<link rel="stylesheet" type="text/css" href="static/css/editor.css">
<title>Text to Chart Api Editor</title>
<?php
require 'config.php';
$clientId = $config['ad']['google'];
$googlead = <<<EOF
<script data-ad-client="ca-pub-$clientId" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
EOF;

if ($clientId != "") {
	echo $googlead;
}
?>
</head>
<body>
<a class="github-fork-ribbon" href="https://github.com/annprog/chart" data-ribbon="Fork me on GitHub" title="Fork me on GitHub">Fork me on GitHub</a>
<div id="content">
<div id="title"><h1>Text to Chart API</h1></div>
<div id="demo" style="display:none"></div>
<div id="editor">
<form id="chart-editor" accept-charset="utf-8" name="editor" method="POST" action="
<?php echo $config['api'];?>
" enctype="application/x-www-form-urlencoded">
	<textarea name="chl" id="chl"></textarea>
	<br>
	<select id="cht" name="cht"></select>
	<label for="chof">&nbsp;Format:&nbsp;</label>
	<input type="" name="chof" value="" id="chof" size=5 placeholder="png">
	<input type="button" id="submit" name="submit" value="Submit" onclick=preview();>
</form>
</div>
<div style="text-align:center; margin:0 auto;" id="preview">
	<img id="imgpreview" style="max-width:95%;" src="static/error.png" alt="chart" title="chart"/>
</div>
</div>
<script src="static/js/editor.js"></script>
<?php
$baidu = $config['analytics']['baidu'];
$baiduScript = <<<EOF
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?$baidu";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
EOF;
if ($baidu != "") {
	echo $baiduScript;
}
?>
</body>
</html>
