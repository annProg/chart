<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2022-11-10 21:30:00
 **/
$config['engine']['lp'] = array(
	"desc"=>"Chinese license plate",
	"usage" => "license plate",
	"class" => "lp",
	"demo" => "String"
);
$config['engine']['lp:blue'] = array(
	"desc"=>"Chinese license plate(Blue)",
	"usage" => "license plate",
	"class" => "lp",
	"demo" => "String"
);
$config['engine']['lp:yellow'] = array(
	"desc"=>"Chinese license plate(Yellow)",
	"usage" => "license plate",
	"class" => "lp",
	"demo" => "String"
);
$config['engine']['lp:black'] = array(
	"desc"=>"Chinese license plate(Black)",
	"usage" => "license plate",
	"class" => "lp",
	"demo" => "String"
);
$config['engine']['white'] = array(
	"desc"=>"Chinese license plate(White)",
	"usage" => "license plate",
	"class" => "lp",
	"demo" => "String"
);

require __DIR__.'/../vendor/autoload.php';

class lp extends plot {
	private $valid_chof = array("jpg", "png", "svg");
	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "jpg";
		}

		if($this->width == "") {
			$this->width = "120";
			$this->height = "120";
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);

		$saveDir = "./cache/tmp/";
		if(!is_dir($saveDir)) {
			mkdir($saveDir);
		}

		$plate = new Zyan\LicensePlateNumber\LicensePlateNumber($saveDir);
		$cht = explode(":", $this->cht);
		$engine = end($cht);

		$lp = mb_str_split($this->chl);
		switch($engine) {
			case "yellow":
				$res = $plate->yellow(...$lp);
				break;
			case "blue":
				$res = $plate->blue(...$lp);
				break;
			case "black":
				$res = $plate->black(...$lp);
				break;
			case "white":
				$res = $plate->white(...$lp);
				break;
			default:
				$res = $plate->yellow(...$lp);
		}
		$ret = copy($res->getFilename(), $this->ofile);
		if(!$ret) {
			$this->onerr();
		}

		$resize = "mogrify -resize " . $this->width . "x" . $this->height . " " . $this->ofile;
		if($this->width && $this->height) {
			exec($resize, $out, $res);
			if($res != 0) {
				$this->onerr();
			}
		}
		
		return $this->result();
	}
}
