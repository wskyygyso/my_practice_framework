<?php
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'system.php';
//加载配置
$config = require LIBRARY_PATH . DIRECTORY_SEPARATOR . 'Config.php';
$debug = isset($config['debug']) ?? APP_DEBUG;
if ($debug) {
    //显示错误
    ini_set('display_errors', 'on');
    //所有错误
    error_reporting(E_ALL);
}
//composer 自动加载
require __DIR__ . '/../vendor/autoload.php';
//运行
$app = (new \Library\Application(new \Library\Http\Request(), $config));
$app->run();
