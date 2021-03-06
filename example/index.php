<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/customTransformer.php";

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Jimb\RestFilter\CommonTransformer;
use Jimb\customTransformer;

// 新建一个全局管理类
$fractal = new Manager();

$companys = [
    [
        'id' => '1',
        'name' => 'jianbin',
        'myinfo' => [
            'name' => 'kankanJ',
            'car'  => [
                'id' => 123,
                'name'  => "car",
                'yic' => [
                    'name' => 'hhhhcao'
                ]
            ]
        ]
    ],
    [
        'id' => '2',
        'name' => 'jimb55',
        'myinfo' => [
            'name' => 'MWIJD',
            'car'  => [
                'id' => 121,
                'name'  => "bus",
                'yic' => [
                    'name' => 'bilibili'
                ]
            ]
        ]
    ]
];
//or

//$companys = [
//    'id' => '1',
//    'name' => 'jianbin',
//    'jgdaima' => 'WBERBKJKJEWR',
//    'date' => '1998',
//    'adresss' => '广州的某某小吃店',
//    'email' => 'tangtang@gmail.org',
//];

//列表
$resource = new Collection($companys, new CommonTransformer);
//$resource = new Collection($companys, new customTransformer);

//单项
//$resource = new Item($companys, new CommonTransformer);


// 返回
echo $fractal->createData($resource)->toJson();