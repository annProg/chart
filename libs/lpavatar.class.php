<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2022-11-10 21:30:00
 **/
$config['engine']['lpavatar'] = array(
	"desc"=>"Chinese license plate avatar",
	"usage" => "license plate",
	"class" => "lpavatar",
	"demo" => "000.00.01.34"
);

require __DIR__.'/../vendor/autoload.php';

class lpavatar extends plot {
	private $valid_chof = array("jpg", "png");
	protected $lp;
	protected $province;
	protected $city;
	protected $num;
	function __construct($args) {
		parent::__construct($args);
		if(!in_array($this->chof, $this->valid_chof)) {
			$this->chof = "jpg";
		}
		$this->width = "120";

		$this->province = ["京","津","沪","渝","冀","豫","云","辽","黑","湘","皖","鲁","新","苏","浙","赣","鄂","桂","甘","晋","蒙","陕","吉","闽","贵","粤","青","藏","川","宁","琼"];
		$this->city = ["A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z"];
		$this->num = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9","A","B","C","D","E","F","G","H","J","K","L","M","N","P","Q","R","S","T","U","V","W","X","Y","Z"];

		$this->getlp();
	}

	function gettruck() {
		$baseDir = "./cache/truck/";
		$handle=opendir($baseDir);
		//定义用于存储文件名的数组
		$trucks = array();
		while (false !== ($file = readdir($handle)))
		{
			if ($file != "." && $file != "..") {
			$trucks[] = $file; //输出文件名
		}
		}
		closedir($handle);
		$uid = str_replace(".", "", $this->chl);
		$sum = count($trucks);
		return $baseDir . $trucks[$uid%$sum];
	}

	function getlp() {
		$uid = explode(".", $this->chl);
		if(count($uid) != 4) {
			$this->onerr();
		}

		$province = $this->province[$uid[3]%31];
		$city = $this->city[$uid[3]%24];
		$lp1 = $this->num[$uid[1]%34];
		$lp2 = $this->num[$uid[2]/10];
		$lp3 = $this->num[$uid[2]%10];
		$lp4 = $this->num[$uid[3]/10];
		$lp5 = $this->num[$uid[3]%10];

		$this->lp = [$province, $city, $lp1, $lp2, $lp3, $lp4, $lp5];
	}

	function render() {
		$p = parent::render();
		if($p) return($p);

		$saveDir = "./cache/tmp/";
		if(!is_dir($saveDir)) {
			mkdir($saveDir);
		}

		$plate = new Zyan\LicensePlateNumber\LicensePlateNumber($saveDir);

		$res = $plate->yellow(...$this->lp);
		$lpfile = $res->getFilename();

		exec("mogrify -resize " . $this->width . " " . $lpfile, $out, $res);
		$combine = "convert -append " . $this->gettruck() . " " . $lpfile . " " . $this->ofile;
		exec($combine, $out, $res);

		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
