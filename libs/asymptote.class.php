<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['asy'] = array(
	"desc"=>"Asymptote",
	"usage" => "Asymptote language. see http://asymptote.sourceforge.net/",
	"class" => "asymptote",
	"demo" => <<<EOF
filldraw( (4cm,0) -- (4cm,3cm) -- (0,3cm) -- cycle,
fillpen=palered, drawpen=red+0.5mm);
filldraw( (7cm,4cm) -- (4cm,4cm) -- (4cm,0) -- cycle,
	fillpen=palered, drawpen=red+0.5mm);
filldraw( (3cm,7cm) -- (3cm,4cm) -- (7cm,4cm) -- cycle,
	fillpen=palered, drawpen=red+0.5mm);
filldraw( (0,3cm) -- (3cm,3cm) -- (3cm,7cm) -- cycle,
	fillpen=palered, drawpen=red+0.5mm);
EOF
);

class asymptote extends plot {
	private $valid_chof = array("png","jpg","gif","pdf","eps", "svg");
	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		$ofile = explode(".", $this->ofile)[0];
		exec("export PATH=\"/bin:\$PATH\";asy --libgs=\"\" $this->ifile -f $this->chof -o $ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
