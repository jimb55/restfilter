<?php

require __DIR__ . "/../vendor/autoload.php";

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Jimb\RestFilter\CommonTransformer;

// 新建一个全局管理类
$fractal = new Manager();

$books = [
    [
        'id' => '1',
        'title' => 'Hogfather',
        'name' => 'jiabi',
        'yr' => '1998',
        'author_name' => 'Philip K Dick',
        'author_email' => 'philip@example.org',
    ],
    [
        'id' => '2',
        'title' => 'Game Of Kill Everyone',
        'yr' => '2014',
        'name' => '223',
        'author_name' => 'George R. R. Satan',
        'author_email' => 'george@example.org',
        'myinfo' => [
            'name' => 'jimb55',
            'githubPage' => 'github://jimb55',
            'age' => '22',
            'like' => 'i down no'
        ]
    ]
];

//or

//$book = [
//    'id' => '1',
//    'title' => 'Hogfather',
//    'name' => 'jiabi',
//    'yr' => '1998',
//    'author_name' => 'Philip K Dick',
//    'author_email' => 'philip@example.org',
//];

//列表
$resource = new Collection($books, new CommonTransformer);

//单项
//$resource = new Item($book, new CommonTransformer);

// 返回
echo $fractal->createData($resource)->toJson();