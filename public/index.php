<?php
// [ 应用入口文件 ]
namespace think;

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';
define('BIND_MODULE','forum');
define('SITE_URL', 'http://wy.51daoteng.com');

// 执行应用并响应
Container::get('app')->run()->send();
