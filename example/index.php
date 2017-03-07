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
        'jgdaima' => 'WBERBKJKJEWR',
        'date' => '1998',
        'adresss' => 'ggz',
        'email' => 'tangtang@gmail.org',
    ],
    [
        'id' => '2',
        'name' => 'jimb55',
        'jgdaima' => 'FHEWIH3274WENR234NE',
        'date' => '1994',
        'adresss' => 'bbf',
        'email' => 'Jimb@gmail.org',
        'myinfo' => [
            'name' => 'jimb55',
            'githubPage' => 'github://jimb55',
            'age' => '22',
            'like' => 'i down no',
            'car'  => [
                'id' => 123,
                'name'  => "this is a car",
                'yic' => [
                    'name' => 'de'
                ]
            ]
        ]
    ],
    [
        'id' => '3',
        'name' => 'tt',
        'jgdaima' => 'FHEWIH3274WENR234NE',
        'date' => '1994',
        'adresss' => 'ddw',
        'email' => 'www@gmail.org',
        'myinfo' => [
            'name' => 'jjjj',
            'githubPage' => 'hello://world',
            'age' => '22',
            'like' => 'i 222 no'
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