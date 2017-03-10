<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/customTransformer.php";

use Jimb\RestFilter\FractalAdapter;


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

echo FractalAdapter::getInstance() -> collection()-> toJson($companys);