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
	protected $cacheDirCode = "cache/code/";
	protected $cacheDirImg = "cache/images/";
	protected $ifile = "";
	protected $ofile = "";
	protected $errno = 0;
	protected $code = "";   //real code for writeCode

	function __construct($chl,$cht,$chof="png") {
		$this->chl = $chl;
		$this->cht = $cht;
		if($chof != "") {
			$this->chof = $chof;
		}
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
	
	function setCacheDirCode($cacheDirCode) {
		$this->cacheDirCode = $cacheDirCode;
	}
	
	function getCacheDirCode() {
		return $this->cacheDirCode;
	}
	
	function setCacheDirImg($cacheDirImg) {
		$this->cacheDirImg = $cacheDirImg;
	}
	
	function getCacheDirImg() {
		return $this->cacheDirImg;
	}
	
	function ofileName() {
		$flag = str_replace(":", "_", $this->cht);
		return md5($this->chl) . $flag;
	}

	function setIfile() {
		$this->ifile = $this->cacheDirCode . $this->ofileName() . ".txt";
		if(!file_exists($this->cacheDirCode)) {
			mkdir($this->cacheDirCode, 0755, true);
		}
		return $this->ifile;
	}

	function setOfile() {
		$this->ofile = $this->cacheDirImg . $this->ofileName() . "." . $this->chof;
		if(!file_exists($this->cacheDirImg)) {
			mkdir($this->cacheDirImg, 0755, true);
		}
		return $this->ofile;	
	}

	/**
	 * dump $this->chl
	 */
	function writeCode() {
		$code = $this->chl;
		$encode = mb_detect_encoding($this->chl, array("ASCII","UTF-8","GB2312", "GBK", "EUC-CN"));
		if($encode != "UTF-8") { 
			$code = iconv("$encode", "UTF-8", $this->chl);
		}

		$code = str_replace("&gt;", ">", $code);
		$code = str_replace("&lt;", "<", $code);
		$code = str_replace("&quot;", "\"", $code);
		$code = str_replace("<br />", "\n", $code);

		$file = fopen($this->ifile, "w");
		fwrite($file, $code);
		fclose($file);
		return($this->ifile);
	}

	function render() {
		$this->setIfile();
		$this->setOfile();
		$this->writeCode();

		if(file_exists($this->ofile)) {
			return $this->result();
		}
		return false;
	}

	function result() {
		return(array(
			"errno" => $this->errno,
			"imgpath" => $this->ofile,
			"imgtype" => $this->chof,
			"codepath" => $this->ifile
		));
	}

	function onerr() {
		$this->errno = 100;
		$this->ofile = "";
	}
}
