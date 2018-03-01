<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['qr'] = array(
	"desc"=>"QRcode",
	"usage" => "strings",
	"class" => "qrcode"
);

class qrcode extends plot {
	function __construct($args) {
		parent::__construct($args);
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
