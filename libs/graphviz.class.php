<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['gv'] = array(
	"desc"=>"Graphviz",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:dot'] = array(
	"desc"=>"Graphviz(Dot)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:neato'] = array(
	"desc"=>"Graphviz(Neato)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:fdp'] = array(
	"desc"=>"Graphviz(Fdp)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:sfdp'] = array(
	"desc"=>"Graphviz(Sfdp)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:twopi'] = array(
	"desc"=>"Graphviz(Twopi)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);
$config['engine']['gv:circo'] = array(
	"desc"=>"Graphviz(Circo)",
	"usage" => "http://www.graphviz.org/",
	"class" => "graphviz"
);

class graphviz extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		$cht = explode(":", $this->cht);
		$engine = end($cht);
		if($engine == "gv") $engine = "dot";
		exec("$engine -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
