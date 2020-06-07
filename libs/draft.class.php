<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['draft'] = array(
	"desc"=>"Microservice Architecture diagrams",
	"usage" => "https://github.com/lucasepe/draft",
	"class" => "draft",
	"demo" => <<<EOF
title: Upload file to S3 using Lambda for pre-signed URL
backgroundColor: '#ffffff'
components:
  -
    kind: client
    label: "Web App"
    provider: SPA
  -
    kind: gateway
    provider: "AWS API Gateway"
  -
    kind: function
    label: "Get\\nPre-Signed URL"
    provider: "AWS Lambda"
  -
    kind: storage
    label: "*.jpg\\n*.png"
    provider: "AWS S3"
connections:
  -
    origin:
      componentId: cl1
    targets:
      -
        componentId: gt1
  -
    origin:
      componentId: gt1
    targets:
      -
        componentId: fn1
  -
    origin:
      componentId: fn1
    targets:
      -
        componentId: st1
EOF
);

class draft extends plot {
	private $valid_chof = array("png","svg","eps","pdf","jpg","gif");

	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("draft $this->ifile |dot -T$this->chof -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
