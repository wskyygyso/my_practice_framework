<?php
//debug
defined('APP_DEBUG') or define('APP_DEBUG', true);
//运行开始时间
defined('APP_START_TIME') or define('APP_START_TIME', microtime(true));
//应用目录
defined('APP_PATH') or define('APP_PATH', __DIR__ . DIRECTORY_SEPARATOR . 'app');
//核心目录
defined('LIBRARY_PATH') or define('LIBRARY_PATH', APP_PATH . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'library');
//入口目录
defined('PUBLIC_PATH') or define('PUBLIC_PATH', APP_PATH . '..' . DIRECTORY_SEPARATOR . 'public');

