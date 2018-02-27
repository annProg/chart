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
	private $subtitle = "";
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
		if(array_key_exists("0", $arr)) $this->title = trim($arr[0]);
		if(array_key_exists("1", $arr)) $this->author = trim($arr[1]);
		if(array_key_exists("2", $arr)) $this->subtitle = trim($arr[2]);
	}

	function render() {
		$engine = end(explode(":", $this->cht));
		if($engine == "ten") {
			$this->chof = "png";
		}
		$p = parent::render();
		if($p) return($p);
		$ofile = substr($this->ofile, 0, -4);
		if($engine == "cover") {
			$cmd = 'export LANG=zh_CN.UTF-8;racovimge "' . $this->title . '" -a "' . $this->author . '" ' . 
				$this->format . ' -o ' . $ofile;
		} else if ($engine == "ten") {
			$cmd = 'export LANG=zh_CN.UTF-8;./tools/tenprintcover.py -t "' . $this->title . '" -a "' . 
				$this->author . '" -s "' . $this->subtitle . '" -o ' . $this->ofile;
		}
		exec($cmd, $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
