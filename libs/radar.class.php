<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['radar'] = array(
	"desc"=>"Radar Chart",
	"usage" => "use csv format",
	"class" => "radar",
	"demo" => <<<EOF
name,价格,易用性,性能,外观,功能
iphoneX,.5,.9,1,.9,.8
Mi6,.8,.9,.9,.8,.8
P10,.6,.9,.9,.8,.8
EOF
);

class radar extends plot {
	private $js = <<<EOF
'use strict'
const radar = require('svg-radar-chart')
const stringify = require('virtual-dom-stringify')
EOF;
	private $svg = <<<EOF
var opt={shapeProps: (data) => ({className: 'shape ' + data.class}), size:100}
const chart = radar(columns,data,opt)
process.stdout.write(`<svg version="1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
	<style>
		.axis {
			stroke: #555;
			stroke-width: .2;
		}
		.scale {
			fill: #f0f0f0;
			stroke: #999;
			stroke-width: .2;
		}
		.shape {
			fill-opacity: .3;
			stroke-width: .5;
		}
		.shape:hover { fill-opacity: .6; }
		\${style}
	</style>
	\${stringify(chart)}
</svg>
`)
EOF;

	private $node_path = "/usr/lib/node_modules";

	function __construct($args) {
		parent::__construct($args);
		$this->chof="svg";
	}

	function __get($property_name) {
		if(!isset($this->$property_name)) {
			return(NULL);
		}
		return($this->$property_name);
	}
	
	function __set($property_name, $value) {
		if(!isset($this->$property_name)) {
			return(false);
		}
		$this->$property_name = $value;
	}

	function random_color() {
		$colors = array();
		for($i = 0;$i<6;$i++) {
			$colors[] = dechex(rand(0,15));
		}
		return "#" . implode('',$colors);
	}

	function csv2radar() {
		$csv = preg_replace("/\r\n?/", "\n", $this->chl);
		$arr = explode("\n", $csv);
		$arr = array_filter($arr, function($k) {
			$v = str_replace(" ", "", $k);
			if($v == "") return false;
			return true;
		});
		$arr = array_values($arr);

		$columns = explode(",",$arr[0]);
		unset($arr[0]);
		$len = count($columns);
		
		$co = "var columns={";
		foreach($columns as $k => $v) {
			if($k == 0) continue;
			$co .= "c" . $k . ":" . "'" . $v . "',";
		}
		$co .= "}";
	
		$style = "var style='";
		$data = "var data=[";
		foreach($arr as $key => $val) {
			$d = explode(",", $val);
			$data .= "{class:'" . $d[0] . "',";
			foreach($d as $k => $v) {
				if($k == 0) continue;
				$data .= "c" . $k . ":" . $v . ",";
			}
			$color = $this->random_color();
			$style .= ".shape." . $d[0] . "{ fill:" . $color . "; stroke: " . $color . "; }  ";
			$data .= "},";
		}
		$data .= "]";
		$style .= "'";
		return $this->js . "\n" . $style . "\n" .  $co . "\n". $data . "\n" . $this->svg;
	}

	function writeCode() {
		$this->chl = $this->csv2radar();
		parent::writeCode();
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("export NODE_PATH=$this->node_path;node $this->ifile &> $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
