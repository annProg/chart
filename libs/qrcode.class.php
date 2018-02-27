<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class qrcode extends plot {
	function __construct($chl, $cht, $chof="png", $chs="") {
		parent::__construct($chl, $cht, $chof, $chs);
		$this->chof = "png";
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("myqr \"$this->chl\" -n $this->ofile", $out, $res);
		$resize = "mogrify -resize " . $this->width . "x" . $this->height . " " . $this->ofile;
		if($this->width && $this->height) {
			exec($resize, $out, $res);
		}
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
