# 过滤你的API接口
1在一些API接口中,容易存在不必要的数据,例如某个表格需要输出一个公司的列表,然后列表需要公司的名字,地址,机构代码,id...等等的信息,然后做了这
个接口.在其他的某些地方,例如需要做一个公司的下拉选择框,但这时上述接口却返回许多不必要的数据(地址,机构代码...),明明我只关注的是id,名字
这两个字段,这就容易做成网络io流失了.而`restfilter`就是在不影响业务代码的情况下解决这个问题.
<br>2把返回json 交给前端,发送的字段会自动补全结构,前端就不会因为找不到字段而报错

# 安装
```
composer require jimb/restfilter
```

# 使用
```php

use League\Fractal\Manager;

// 新建一个全局管理类
// 这个管理类可以是单一的,放在全局的
$fractal = new Manager();

```
<br> 使用非常简单,当然下面只是一个例子,把代码放在一个文件,应该是管理类独立开来,数据有在数据模型上取等等
```php

<?php

require __DIR__ . "/../vendor/autoload.php";

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use Jimb\RestFilter\CommonTransformer;

// 新建一个全局管理类
$fractal = new Manager();

$companys = [
    [
        'id' => '1',
        'name' => 'jianbin',
        'jgdaima' => 'WBERBKJKJEWR',
        'date' => '1998',
        'adresss' => '广州的某某小吃店',
        'email' => 'tangtang@gmail.org',
    ],
    [
        'id' => '2',
        'name' => 'jimb55',
        'jgdaima' => 'FHEWIH3274WENR234NE',
        'date' => '1994',
        'adresss' => '北方的最高雪山',
        'email' => 'Jimb@gmail.org',
        'myinfo' => [
            'name' => 'jimb55',
            'githubPage' => 'github://jimb55',
            'age' => '22',
            'like' => 'i down no'
        ]
    ],
    [
        'id' => '3',
        'name' => '糖糖',
        'jgdaima' => 'FHEWIH3274WENR234NE',
        'date' => '1994',
        'adresss' => '东方最热的温泉',
        'email' => 'www@gmail.org',
        'myinfo' => [
            'name' => 'jjjj',
            'githubPage' => 'hello://world',
            'age' => '22',
            'like' => 'i 222 no'
        ]
    ]
];

$resource = new Collection($companys, new CommonTransformer);

// 返回
echo $fractal->createData($resource)->toJson();

```

<br> 下面的是返回一个对象的
```php
<?php

require __DIR__ . "/../vendor/autoload.php";

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Jimb\RestFilter\CommonTransformer;

// 新建一个全局管理类
$fractal = new Manager();

$companys = [
    'id' => '1',
    'name' => 'jianbin',
    'jgdaima' => 'WBERBKJKJEWR',
    'date' => '1998',
    'adresss' => '广州的某某小吃店.',
    'email' => 'tangtang@gmail.org',
];


//单项
$resource = new Item($companys, new CommonTransformer);

// 返回
echo $fractal->createData($resource)->toJson();
```
*这个 package 只提供过滤功能,详细的Fractal对象接口可以参考 *
<br>地址 : [Fractal](http://fractal.thephpleague.com/ "Fractal 文档")

然后访问时在你需要的连接上加上 参数 `fields` 就可以,例如example 上的
```
http://127.0.0.1/example/?fields=id,name
```

子级别对象的
```
http://127.0.0.1/example/?fields=id,name,myinfo.name
```

<br> 如果你想更加简单 可以使用 FractalAdapter
```php
<?php

require __DIR__ . "/../vendor/autoload.php";
require __DIR__ . "/customTransformer.php";

use Jimb\RestFilter\FractalAdapter;
$companys = [...];
echo FractalAdapter::getInstance() -> collection()-> toJson($companys);
//单项
//echo FractalAdapter::getInstance() -> item()-> toJson($companys);
```

参数 `fields` 是可以修改了,下面讲到
<br> 这里显示过滤前改变返回结构和更改过滤的参数名
```php
<?php
namespace Jimb;

use Jimb\RestFilter\CommonTransformer;

/**
 * CommonTransformer 过滤转化器
 * Class CommonTransformer
 */
class customTransformer extends CommonTransformer
{
    //覆盖父类的 $filedName 为过滤参数的参数名
    protected $filedName = "custom";

    /**
     * @param $model
     * @return array
     */
    public function transform($model)
    {

        // $model是一个item 就是你要过滤的返回数据
        // 在过滤前你可以改变 $model 的任何结构
        // 但注意不要因为结构改变了导致$filed 字段找不到值,是重构结构了才会过滤的

        return parent::transform([
            'id' => $model["id"]."+".$model["name"],
            'name' => "my name is ".$model["name"],
        ]);
    }
}
```

# Laravel 支持

安装依然一样，可以加到 require
```
"require": { 
    "php": ">=5.6.4", 
    "jimb/restfilter":"0.1.*"
 }
```
注册服务提供者 `config/app.php`
```
Jimb\RestFilter\RestFilterProvider::class
```

使用
==========
```php

return app('RestFilter') -> collection() ->toJson(Product::orderBy ( 'id', 'desc' )-> get() -> toArray());

```






