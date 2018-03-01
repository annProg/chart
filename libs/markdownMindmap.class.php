<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['markdown'] = array(
	"desc"=>"MindMap",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:dot'] = array(
	"desc"=>"MindMap(Dot)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:neato'] = array(
	"desc"=>"MindMap(Neato)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:fdp'] = array(
	"desc"=>"MindMap(Fdp)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:sfdp'] = array(
	"desc"=>"MindMap(Sfdp)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:twopi'] = array(
	"desc"=>"MindMap(Twopi)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);
$config['engine']['markdown:circo'] = array(
	"desc"=>"MindMap(Circo)",
	"usage" => "# Title 1\n## Title 2\n### Title3",
	"class" => "markdownMindmap"
);

class markdownMindmap extends plot {
	private $edgecolor = "limegreen";
	private $fontname = "WenQuanYi Micro Hei";
	private $fontcolor = "white";
	private $bgcolor = "#012b37";
	private $rankdir = "LR";
	private $pack = "true";
	private $overlap = "false";
	private $splines = "curved";
	private $colorH1 = "lightgreen";
	private $shape = "plaintext";
	private $penwidth = 6;
	private $colorbase = array("tomato", "yellow", "skyblue", "tan", "thistle", "palegreen", "darkseagreen");
	private $colorMatrix = array();
	private $nodeStyle = "rounded";

	function __construct($args) {
		parent::__construct($args);
		$this->colorMatrix = array(
			$this->colorbase, array_reverse($this->colorbase), $this->colorbase, 
			$this->colorbase, array_reverse($this->colorbase),$this->colorbase
		);
	}

	function __get($property_name) {
		if(!isset($this->$property_name)) {
			return(NULL);
		}
		return($this->$property_name);
	}
	
	function __set($property_name, $value) {
		if(!isset($this->$property_name)) {
			return(false);
		}
		$this->$property_name = $value;
	}

	function dotOptions() {
		return 'digraph G{bgcolor="' . $this->bgcolor . '";rankdir="' . $this->rankdir . 
			'";pack=' . $this->pack . ';overlap=' . $this->overlap . ';splines=' . $this->splines . 
			';fontname="' . $this->fontname . '";node[fontname="' . $this->fontname . 
			'";shape="' . $this->shape . '";style="' . $this->nodeStyle . '";fontcolor="' . 
			$this->fontcolor . '"];edge[concentrate=true,penwidth=' . $this->penwidth . ',dir=none]';
	}

	function markdown2dot() {
		$dotOptions = $this->dotOptions();
		$md = preg_replace("/\r\n?/", "\n", $this->chl);
		$arr = explode("\n", $md);
		$arr = array_filter($arr, function($k) {
			$v = str_replace(" ", "", $k);
			if($v == "") return false;
			return true;
		});
		$arr = array_values($arr);

		$len = count($arr);
		$nodes = array();
		$edges = array();
		$matrixLen = count($this->colorMatrix);
		$baseLen = count($this->colorbase);

		for($i = 0; $i<$len; $i++)
		{
			$m = preg_match('/^(#+?)\s+(.*)$/', $arr[$i], $matches);
			if(!$m) continue;
			$level = strlen($matches[1]);
			$label = $matches[2];
			$tag = "H" . $level;
			$node = $tag . "_" . $i;
			$prev = "";
			$arr[$i] = $tag . " " . $label;

			$expectTag = "H" . ($level - 1);
			$j = $i;
			while($j >= 0)
			{
				if(explode(" ", $arr[$j])[0] == $expectTag) {
					$prev = $expectTag . "_" . $j;
					break;
				}
				$j--;
			}

			if($j < 0) $j = 0;

			$edgecolor = $this->colorMatrix[$level%$matrixLen][$j%$baseLen];
			$edgeOption = '';
			switch($tag) {
				//case "H1": $shape = $this->shapeH1;break;
				case "H2": //$shape = $this->shapeH2;
					$edgecolor = $this->colorMatrix[rand(0,$matrixLen-1)][rand(0, $baseLen-1)];
					$edgeOption = '[dir=forward,style="tapered",penwidth=12,arrowhead=none,color="' . $edgecolor . '"]';break;
				default: $shape = $this->shape;
					$edgeOption = '[color="' . $edgecolor . '"]';
			}

			$fontsize = 43 - 5*$level;
			if($fontsize < 10) $fontsize = 10;

			if($label) {
				$n = $node . '[label="' . $label . '",fontsize="' . $fontsize . '"];';
				array_push($nodes, $n );	
			}

			if($prev) {
				array_push($edges, $prev . '->' . $node . $edgeOption . ';');
			}

		}
		$dot = $dotOptions . "\n" . implode("\n", $nodes) . "\n" . implode("\n", $edges) . "\n}";
		return($dot);
	}

	function writeCode() {
		$this->chl = $this->markdown2dot();
		parent::writeCode();
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		$cht = explode(":", $this->cht);
		$engine = end($cht);
		if($engine == "markdown") $engine = "dot";
		exec("$engine -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
