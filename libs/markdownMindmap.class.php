<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/

require 'plot.class.php';

class markdownMindmap extends plot {
	private $color = "gainsboro";
	private $fillcolor = "limegreen";
	private $colorH1 = "lightgreen";
	private $shape = "ellipse";
	//private $shape = "signature";
	private $shapeH1 = "circle";
	private $shapeH2 = "box";
	private $colorbase = array("tomato", "yellow", "skyblue", "tan", "thistle", "palegreen", "darkseagreen");
	private $colorMatrix = array();
	private $dotOptions = 'digraph G{rankdir="LR";pack=true;overlap=false;splines=true;edge[color="silver"];';

	function __construct($chl,$cht,$chof="png") {
		parent::__construct($chl,$cht,$chof);
		$this->colorMatrix = array(
			$this->colorbase, array_reverse($this->colorbase), $this->colorbase, 
			$this->colorbase, array_reverse($this->colorbase),$this->colorbase
		);
	}
	function setColorBase($colorbase) {
		$this->colorbase = $colorbase;
	}

	function setColorMatrix($matrix) {
		$this->colorMatrix = $matrix;
	}

	function setColor($color) {
		$this->color = $color;
	}

	function setFillColor($color) {
		$this->fillcolor = $color;
	}

	function setColorH1($color) {
		$this->colorH1 = $color;
	}

	function setShape($shape) {
		$this->shape = $shape;
	}

	function setShapeH1($shape) {
		$this->shapeH1 = $shape;
	}

	function setShapeH2($shape) {
		$this->shapeH2 = $shape;
	}

	function setDotOptions($dot) {
		$this->dotOptions = $dot;
	}

	function markdown2dot() {
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

			$color = $this->color;
			$fillcolor = $this->colorMatrix[$level%$matrixLen][$j%$baseLen];
			$edgeOption = '';
			switch($tag) {
				case "H1": $fillcolor = $this->fillcolor; $color = $this->colorH1; $shape = $this->shapeH1;break;
				case "H2": $shape = $this->shapeH2;
					$edgecolor = $this->colorMatrix[rand(0,$matrixLen-1)][rand(0, $baseLen-1)];
					$edgeOption = '[style="tapered",penwidth=6,arrowhead=none,color="' . $edgecolor . '"]';break;
				default: $shape = $this->shape;
			}

			$fontsize = 24 - 4*$level;
			if($fontsize < 10) $fontsize = 10;

			if($label) {
				$n = $node . '[label="' . $label . '",color="' . $color . '",fontsize="' . $fontsize .
					'",fillcolor="' . $fillcolor . '", style="filled,rounded", shape="' . $shape . '"];';
				array_push($nodes, $n );	
			}

			if($prev) {
				array_push($edges, $prev . '->' . $node . $edgeOption . ';');
			}

		}
		$dot = $this->dotOptions . "\n" . implode("\n", $nodes) . "\n" . implode("\n", $edges) . "\n}";
		return($dot);
	}

	function writeCode() {
		$this->chl = $this->markdown2dot();
		parent::writeCode();
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		$engine = explode(":", $this->cht);
		if(count($engine) == 1) {
			$engine = "dot";
		} else {
			$engine = $engine[1];
		}
		exec("$engine -T$this->chof $this->ifile -o $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
