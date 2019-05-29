<?php
/**
 * Usage:
 * File Name: config.php
 * Author: annhe  
 * Mail: i@annhe.net
 * Created Time: 2017-05-04 17:44:55
 **/

$config = array();
// api链接地址
$config['rooturl'] = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']);
$config['api'] = $config['rooturl'] . "/api.php";
// engine类型
$config['engine'] = array();
// 禁用某些engine
$config['disabled'] = explode(",",getenv("DISABLED"));
// 代码保存路径
$config['cache']['code'] = "./cache/code/";
// 图片保存路径
$config['cache']['image'] = "./cache/images/";
// 错误图片
$config['error'] = "error.png";
$config['node_path'] = "/usr/lib/node_modules";
