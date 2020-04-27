<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['avatar'] = array(
	"desc"=>"Identicon Avatar",
	"usage" => "Identicon",
	"class" => "identicon",
	"demo" => "String"
);

require __DIR__.'/../vendor/autoload.php';

class identicon extends plot {
	private $valid_chof = array("png", "svg");
	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}

		if($this->width == "") {
			$this->width = "120";
			$this->height = "120";
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);

		$identicon = new \Identicon\Identicon();
		$img = $identicon->getImageData($this->chl, $this->width);
		$f = fopen($this->ofile, "wb");
		$res = fwrite($f, $img);
		fclose($f);
		if(!$res) {
			$this->onerr();
		}
		return $this->result();
	}
}
