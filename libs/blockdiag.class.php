<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class blockdiag extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("blockdiag -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
