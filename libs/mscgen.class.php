<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['msc'] = array(
	"desc"=>"Message Sequence Chart",
	"usage" => "http://www.mcternan.me.uk/mscgen/",
	"class" => "mscgen"
);

class mscgen extends plot {
	private $valid_chof = array("png","svg","eps");

	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("mscgen -T$this->chof -i $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
