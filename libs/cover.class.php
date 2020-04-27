<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/

$config['engine']['cover'] = array(
	"desc"=>"Book Cover",
	"usage" => "Title\nAuthor",
	"class" => "cover",
	"demo" => <<<EOF
Title
Author
EOF
);
$config['engine']['cover:ten'] = array(
	"desc"=>"Book Cover(tenprintcover)",
	"usage" => "Title\nAuthor\nSubTitle",
	"class" => "cover",
	"demo" => <<<EOF
Title
Author
SubTitle
EOF
);
	
class cover extends plot {
	private $valid_chof = array("png","svg");
	private $title = "Book Title";
	private $subtitle = "";
	private $author = "Annhe";
	private $format = " --png";

	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "png";
		}
		if($this->chof == "svg") {
			$this->format = "";
		}
		$this->parse();
		$arr = array('"', ';', '<', '>');
		$this->title = substr($this->_filter($arr, $this->title), 0, 50);
		$this->subtitle = substr($this->_filter($arr, $this->subtitle), 0, 50);
		$this->author = substr($this->_filter($arr, $this->author), 0, 20);
	}

	function parse() {
		$arr = explode("\n", $this->chl);
		if(array_key_exists("0", $arr)) $this->title = trim($arr[0]);
		if(array_key_exists("1", $arr)) $this->author = trim($arr[1]);
		if(array_key_exists("2", $arr)) $this->subtitle = trim($arr[2]);
	}

	function render() {
		$cht = explode(":", $this->cht);
		$engine = end($cht);
		if($engine == "ten") {
			$this->chof = "png";
		}
		$p = parent::render();
		if($p) return($p);
		$ofile = substr($this->ofile, 0, -4);
		if($engine == "cover") {
			$cmd = 'export LANG=zh_CN.UTF-8;racovimge "' . $this->title . '" -a "' . $this->author . '" ' . 
				$this->format . ' -o ' . $ofile;
		} else if ($engine == "ten") {
			if ($this->subtitle == "") $this->subtitle = "Subtitle";
			$cmd = 'export LANG=zh_CN.UTF-8;tenprintcover.py -t "' . $this->title . '" -a "' . 
				$this->author . '" -s "' . $this->subtitle . '" -o ' . $this->ofile;
		}
		exec($cmd, $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
