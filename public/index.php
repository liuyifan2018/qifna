<?php
// [ 应用入口文件 ]
namespace think;

// 加载基础文件
require __DIR__ . '/../thinkphp/base.php';
define('SITE_URL', 'localhost/forum');

// 执行应用并响应
Container::get('app')->run()->send();
