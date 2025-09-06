<?php
/**
 * Usage:
 * File Name:
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-12-16 02:44:03
 **/
$config['engine']['radar'] = array(
	"desc"=>"Radar Chart",
	"usage" => "use csv format",
	"class" => "radar",
	"demo" => <<<EOF
title:雷达图测试
max:100
name,价格,易用性,性能,外观,功能
iphoneX,90,90,90,90,85
Mi16,80,85,90,80,90
P10,80,80,70,70,70
EOF
);

class radar extends plot {
	private $js;
	private $config;
	private $title;
	private $labels;
	private $datasets;
	private $max;
	private $colors;

	private $node_path = "/usr/local/node/lib/node_modules";

	function __construct($args) {
		parent::__construct($args);
		$this->chof="jpg";
		$this->colors = [];
		$this->js = <<<EOF
const fs = require('fs');
const { ChartJSNodeCanvas } = require('chartjs-node-canvas');

// 初始化Canvas渲染服务
const width = 1200; // 图片宽度（像素）
const height = 1200; // 图片高度（像素）
const chartJSNodeCanvas = new ChartJSNodeCanvas({ width, height, backgroundColour: 'white' });
EOF;
		$this->config = <<<EOF
// 配置雷达图
const configuration = {
	type: 'radar',
	data: {
		labels: labels,
		datasets: datasets,
	},
	options: {
		plugins: {
			legend: {
				display: true,
				position: 'bottom',
				labels: {
					font: {
						size: 24, // 图例字体大小
						family: 'Arial', // 可选：字体类型
						weight: 'bold', // 可选：字体粗细
					},
				},
			},
			title: {
				display: true,
				text: title,
				font: {
					size: 36, // 标题字体大小
					family: 'Arial',
					weight: 'bold',
				},
			},
		},
		scales: {
			r: {
				grid: {
					circular: true,
				},
				min: 0,
				max: max,
				ticks: {
					font: {
						size: 20, // 刻度字体大小
						family: 'Arial',
					},
				},
				pointLabels: {
					font: {
						size: 24, // 轴标签(Sales、Marketing等)字体大小
						family: 'Arial',
						weight: 'normal',
					},
				},
			},
		},
	},
};

// 异步生成图片
async function generateChart() {
try {
	const imageBuffer = await chartJSNodeCanvas.renderToBuffer(configuration);
	fs.writeFileSync(outfile, imageBuffer);
} catch (err) {
	console.error('Error generating chart:', err);
}
}
generateChart();
EOF;
	}

	function random_color($attempt = 0, $max_attempts = 3) {
		// 生成随机 HSL 颜色
		$hue = rand(0, 360); // 色调 (0-360)
		$saturation = rand(50, 100); // 饱和度 (50%-100%，避免灰色)
		$lightness = rand(40, 70); // 亮度 (40%-70%，避免太暗或太亮)

		// HSL 转 RGB
		$c = (1 - abs(2 * $lightness / 100 - 1)) * ($saturation / 100);
		$x = $c * (1 - abs(fmod($hue / 60, 2) - 1));
		$m = $lightness / 100 - $c / 2;

		if ($hue < 60) {
			$r = $c; $g = $x; $b = 0;
		} elseif ($hue < 120) {
			$r = $x; $g = $c; $b = 0;
		} elseif ($hue < 180) {
			$r = 0; $g = $c; $b = $x;
		} elseif ($hue < 240) {
			$r = 0; $g = $x; $b = $c;
		} elseif ($hue < 300) {
			$r = $x; $g = 0; $b = $c;
		} else {
			$r = $c; $g = 0; $b = $x;
		}

		// 转换为 0-255 范围并格式化为十六进制
		$r = dechex(round(($r + $m) * 255));
		$g = dechex(round(($g + $m) * 255));
		$b = dechex(round(($b + $m) * 255));

		// 确保两位十六进制
		$r = str_pad($r, 2, '0', STR_PAD_LEFT);
		$g = str_pad($g, 2, '0', STR_PAD_LEFT);
		$b = str_pad($b, 2, '0', STR_PAD_LEFT);

		$color = "#$r$g$b";
		// 检查与已有颜色的对比度
		foreach ($this->colors as $existing) {
			$r1 = hexdec(substr($color, 1, 2));
			$g1 = hexdec(substr($color, 3, 2));
			$b1 = hexdec(substr($color, 5, 2));
			$r2 = hexdec(substr($existing, 1, 2));
			$g2 = hexdec(substr($existing, 3, 2));
			$b2 = hexdec(substr($existing, 5, 2));
			$brightness1 = 0.299 * $r1 + 0.587 * $g1 + 0.114 * $b1;
			$brightness2 = 0.299 * $r2 + 0.587 * $g2 + 0.114 * $b2;
			if ($attempt >= $max_attempts) {
				return $color; // 默认颜色（可自定义）
			}
			if (abs($brightness1 - $brightness2) < 50) {
				return $this->random_color($attempt + 1, $max_attempts); // 递归生成新颜色
			}
		}
		$this->colors[] = $color;
		return $color;
	}

	function random_rgba() {
		$rgba = "rgba(" . rand(0,85) . "," . rand(86,170) . "," . rand(171,255) . "," . 0.2 . ")";
		return $rgba;
	}

	function csv2radar() {
		$csv = preg_replace("/\r\n?/", "\n", $this->chl);
		$arr = explode("\n", $csv);
		$arr = array_filter($arr, function($k) {
			$v = str_replace(" ", "", $k);
			if($v == "") return false;

			if (preg_match("/^title:(.*)/", $v, $m)) {
				$this->title = "var title='" . $m[1] . "';";
				return false;
			}
			if (preg_match("/^max:(.*)/", $v, $m)) {
				$this->max = "var max=" . $m[1] . ";";
				return false;
			}
			return true;
		});
		$arr = array_values($arr);

		$columns = explode(",",$arr[0]);
		unset($arr[0]);
		
		unset($columns[0]);
		$this->labels = "var labels=" . json_encode(array_values($columns));
	
		$datasets = [];
		foreach($arr as $key => $val) {
			$item = array();
			$d = explode(",", $val);
			$item['label'] = $d[0];
			unset($d[0]);
			$item['data'] = array_values($d);
			$item['fill'] = true;
			$item['backgroundColor'] = $this->random_rgba();
			$item['borderColor'] = $this->random_color();
			// $item['pointBackgroundColor'] = $this->random_color();
			// $item['pointBorderColor'] = "#fff";
			$datasets[] = $item;
		}
		$this->datasets = "var datasets=" . json_encode($datasets);
		$outfile = "var outfile='" . $this->ofile . "';";
		return $this->js . "\n" . $this->title . "\n" . $this->max . "\n" .  $this->labels . "\n". $this->datasets . "\n" . $outfile . "\n" . $this->config;
	}

	function writeCode() {
		$this->chl = $this->csv2radar();
		parent::writeCode();
	}

	function render() {
		$p = parent::render();
		if($p) return($p);
		exec("export NODE_PATH=$this->node_path;node < $this->ifile > $this->ofile", $out, $res);
		if($res != 0) {
			$this->onerr();
		}
		return $this->result();
	}
}
