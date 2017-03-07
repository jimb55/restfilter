<?php

/*
|--------------------------------------------------------------------------
| composer 自动载入
|--------------------------------------------------------------------------
| 所测试 phpunit 以 bootstrap 为 入口文件
|
*/

require __DIR__.'/../vendor/autoload.php';

/**
 * 打印数组结构
 */
function dumpArr($data){
    echo "\n";
    echo "[\n";
    foreach($data as $key => $val){
        echo "'$key'".' => '."'$val',"."\n";
    }
    echo ']';
}