<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class mscgen extends plot {
	private $valid_cht = array("png","svg","eps");

	function __construct($chl,$cht,$chof="png") {
		parent::__construct($chl,$cht,$chof);
		if(!in_array($chof, $this->valid_cht)) {
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
