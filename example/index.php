<?php

require __DIR__."/../vendor/autoload.php";

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Jimb\RestFilter\CommonTransformer;

// Create a top level instance somewhere
$fractal = new Manager();

$books = [
    [
        'id' => '1',
        'title' => 'Hogfather',
        'name'  => 'jiabi',
        'yr' => '1998',
        'author_name' => 'Philip K Dick',
        'author_email' => 'philip@example.org',
    ],
    [
        'id' => '2',
        'title' => 'Game Of Kill Everyone',
        'yr' => '2014',
        'name'  => '223',
        'author_name' => 'George R. R. Satan',
        'author_email' => 'george@example.org',
        'myinfo' => [
            'name' => 'jimb55',
            'githubPage'  => 'github://jimb55',
            'age'  =>  '22',
            'like'  => 'i down no'
        ]
    ]
];


//$resource = new Collection($books, function(array $book) {
//    return [
//        'id'      => (int) $book['id'],
//        'title'   => $book['title'],
//        'year'    => (int) $book['yr'],
//        'author'  => [
//            'name'  => $book['author_name'],
//            'email' => $book['author_email'],
//        ],
//        'links'   => [
//            [
//                'rel' => 'self',
//                'uri' => '/books/'.$book['id'],
//            ]
//        ]
//    ];
//});

$resource = new Collection($books, new CommonTransformer );

// Turn that into a structured array (handy for XML views or auto-YAML converting)
//$array = $fractal->createData($resource)->toArray();

// Turn all of that into a JSON string
echo $fractal->createData($resource)->toJson();