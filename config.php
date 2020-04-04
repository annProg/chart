<?php
/**
 * Usage:
 * File Name: config.php
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-05-04 17:44:55
 **/

// php在nginx后通过 HTTP_X_FORWARDED_PROTO 获取正确的 scheme
// Nginx须配置 proxy_set_header X-Forwarded-Proto $scheme;
$scheme = $_SERVER['REQUEST_SCHEME'];
if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) $scheme = $_SERVER['HTTP_X_FORWARDED_PROTO'];

$config = array();
// api链接地址
$config['rooturl'] = $scheme . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$config['api'] = $config['rooturl'] . "api.php";
$config['cdn'] = getenv("CDN");
// engine类型
$config['engine'] = array();
// 禁用某些engine
$config['disabled'] = explode(",",getenv("DISABLED"));
// 代码保存路径
$config['cache']['code'] = "./cache/code/";
// 图片保存路径
$config['cache']['image'] = "./cache/images/";
// 错误图片
$config['error'] = "static/error.png";
$config['node_path'] = "/usr/lib/node_modules";
