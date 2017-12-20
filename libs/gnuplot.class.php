<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class gnuplot extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("gnuplot -e \"set term $this->chof;set output '$this->ofile'\" $this->ifile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
