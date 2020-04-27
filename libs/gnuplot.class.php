<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['gnuplot'] = array(
	"desc"=>"Gnuplot",
	"usage" => "http://gnuplot.sourceforge.net/",
	"class" => "gnuplot",
	"demo" => <<<EOF
plot sin(x)*x;
EOF
);

class gnuplot extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("gnuplot -e \"set term $this->chof;set output '$this->ofile'\" $this->ifile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
