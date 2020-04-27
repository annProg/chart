<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['blockdiag'] = array(
	"desc"=>"Blockdiag",
	"usage" => "http://blockdiag.com/en/",
	"class" => "blockdiag",
	"demo" => <<<EOF
blockdiag {
  default_node_color = lightyellow;
  default_group_color = lightgreen;
  default_linecolor = magenta;
  default_textcolor = red;

  A -> B -> C;
       B -> D;
  group {
    C; D;
  }
}
EOF
);

class blockdiag extends plot {
	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("blockdiag -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
