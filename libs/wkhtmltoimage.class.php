<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2020-04-05 02:44:03
 **/
$config['engine']['url2img'] = array(
	"desc"=>"Wkhtmltoimage",
	"usage" => "base64 encoding url",
	"class" => "wkhtmltoimage"
);

class wkhtmltoimage extends plot {
	private $valid_chof = array("png","jpg");
	private $quality = 85;
	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}
		if ($this->height == "") {
			$this->height = 600;
		}
		if ($this->width == "") {
			$this->width = 800;
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		$url = base64_decode($this->chl);
		preg_match('/^(http:|https:).*/', $url, $matches);
		if (count($matches) < 2) {
			$this->onerr();
		} else {
			exec("wkhtmltoimage --quality $this->quality --height $this->height --width $this->width -f $this->chof \"$url\" $this->ofile", $out, $res);
			if($res != 0) {
				$this->onerr();
			}
		}
		return $this->result();
	}
}
