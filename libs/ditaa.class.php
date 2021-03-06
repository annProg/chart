<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['ditaa'] = array(
	"desc"=>"Ditaa",
	"usage" => "http://ditaa.sourceforge.net/",
	"class" => "ditaa",
	"demo" => <<<EOF
    +--------+   +-------+    +-------+
    |        | --+ ditaa +--> |       |
    |  Text  |   +-------+    |diagram|
    |Document|   |!magic!|    |       |
    |     {d}|   |       |    |       |
    +---+----+   +-------+    +-------+
        :                         ^
        |       Lots of work      |
        +-------------------------+
EOF
);


class ditaa extends plot {
	function __construct($args) {
		parent::__construct($args);
		$this->chof = "png";
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("ditaa $this->ifile $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
