<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class ditaa extends plot {
	function __construct($chl, $cht, $chof="png") {
		parent::__construct($chl, $cht, $chof);
		$this->chof = "png";
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("ditaa $this->ifile $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
