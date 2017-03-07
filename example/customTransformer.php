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
