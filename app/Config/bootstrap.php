<?php
/**
 * キャッシュ設定： ローカルはFile、ステージング・本番はmemcacheにする
 */
Cache::config('default', array(
    'engine' => 'File', //[required]
    'duration' => 3600, //[optional]
    'probability' => 100, //[optional]
    'path' => CACHE, //[optional] use system tmp directory - remember to use absolute path
    'prefix' => 'cake_', //[optional]  prefix every cache file with this string
    'lock' => false, //[optional]  use file locking
    'serialize' => true, //[optional]
    'mask' => 0664,
    //[optional]
));

//Plugin
CakePlugin::loadAll();

Configure::write('Dispatcher.filters', array(
    'AssetDispatcher', 'CacheDispatcher'
));
/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'FileLog', 'types' => array(
        'notice', 'info', 'debug'
    ), 'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'FileLog', 'types' => array(
        'warning', 'error', 'critical', 'alert', 'emergency'
    ), 'file' => 'error',
));
/**
 * 各種ファイルのパス設定
 */
Configure::write('file_path', WWW_ROOT);

/**
 * 定数設定ファイル読み込み
 */
config('const');

require APP . 'Vendor/autoload.php';
