<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
require 'plot.class.php';

class cover extends plot {
	private $valid_cht = array("png","svg");
	private $title = "Book Title";
	private $author = "Annhe";
	private $format = " --png";

	function __construct($chl,$cht,$chof="png") {
		parent::__construct($chl,$cht,$chof);
		if(!in_array($chof, $this->valid_cht)) {
			$this->chof = "png";
		}
		if($chof == "svg") {
			$this->format = "";
		}
		$this->parse();
	}

	function parse() {
		$arr = explode("\n", $this->chl);
		$this->title = trim($arr[0]);
		$this->author = trim($arr[1]);
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		$ofile = substr($this->ofile, 0, -4);
		exec("racovimge $this->title --authors \"$this->author\" $this->format --output $ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
