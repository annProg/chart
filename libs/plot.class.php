<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/

/**
 * common behaviour of plot api
 */
abstract class plot {
	protected $chl = "";     //source code of graph description language
	protected $cht = "";     //plot engine
	protected $chof = "png";    //image type
	protected $cacheCode = "../cache/code/";
	protected $cacheImg = "../cache/images/";

	function __construct($chl,$cht,$chof="png") {
		$this->chl = $chl;
		$this->cht = $cht;
		$this->chof = $chof;
	}

	function setChl($chl) {
		$this->chl = $chl;
	}
	
	function getChl() {
		return $this->chl;
	}
	
	function setCht($cht) {
		$this->cht = $cht;
	}
	
	function getCht() {
		return $this->cht;
	}
	
	function setChof($chof) {
		$this->chof = $chof;
	}
	
	function getChof() {
		return $this->chof;
	}
	
	function setCacheCode($cacheCode) {
		$this->cacheCode = $cacheCode;
	}
	
	function getCacheCode() {
		return $this->cacheCode;
	}
	
	function setCacheImg($cacheImg) {
		$this->chof = $cacheImg;
	}
	
	function getCacheImg() {
		return $this->cacheImg;
	}
	
	function ofileName() {
		$flag = str_replace(":", "_", $this->cht);
		return md5($this->chl) . $flag;
	}

	function codeFilename() {
		return $this->ofileName() . ".txt";
	}

	function imgFilename() {
		return $this->ofileName() . "." . $this->chof;	
	}

	/**
	 * dump $this->chl
	 */
	function writeCode() {
		$encode = mb_detect_encoding($this->chl, array("ASCII","UTF-8","GB2312", "GBK", "EUC-CN"));
		if($encode != "UTF-8") { 
			$code = iconv("$encode", "UTF-8", $this->chl);
		}

		$code = str_replace("&gt;", ">", $code);
		$code = str_replace("&lt;", "<", $code);
		$code = str_replace("&quot;", "\"", $code);
		$code = str_replace("<br />", "\n", $code);

		$filepath = $this->cacheCode . $this->codeFilename();
		$file = fopen($filepath, "w");
		fwrite($file, "$this->chl");
		fclose($file);
		return($filepath);
	}

	function render() {
		$this->writeCode();
		$imgpath = $this->cacheImg . $this->imgFilename();
		if(file_exists($imgpath)) {
			return(array("imgpath"=>$imgpath, "imgtype"=>$this->chof));
		}
	}
}
