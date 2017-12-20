<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class graphviz extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		$engine = end(explode(":", $this->cht));
		if($engine == "gv") $engine = "dot";
		exec("$engine -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
