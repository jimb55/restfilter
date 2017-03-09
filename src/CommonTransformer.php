<?php
namespace Jimb\RestFilter;

use League\Fractal\TransformerAbstract;

/**
 * CommonTransformer 过滤转化器
 * Class CommonTransformer
 */
class CommonTransformer extends TransformerAbstract
{

    //字段值
    private $filed;

    //字段名
    protected $filedName = "fields";

    //是否自动补全结构
    private $isCompletion;

    //补全结构默认值
    private $defaultVal;

    const IS_NOT_IN_ARRAY = 'IS_NOT_IN_ARRAY';

    /**
     * CommonTransformer constructor.
     * @param bool $isCompletion
     * @param string $default
     */
    public function __construct($isCompletion = true, $defaultVal = "")
    {
        $this->isCompletion = $isCompletion;
        $this->defaultVal = $defaultVal;
    }

    /**
     * 参数过滤器
     * @return array
     */
    public function requiteFilter()
    {
        //取得字段值 进处理
        $field = $this->getFiled();

        if ($field !== null && $field) {
            return array_flip(explode(",", $field));
        }
        return false;
    }

    /**
     * 默认转化器
     * @param $model
     * @return array
     */
    public function transform($model)
    {
        return $this->getTransformArr($model);
    }

    /**
     * 取得字段筛选后的素组
     * @param $model
     * @return array
     */
    public function getTransformArr($model)
    {
        //过滤字段
        $filter = $this->requiteFilter();
        if ($filter !== false) {
            return $this->arrayIntersect($model, $filter);
        } else {
            return $model;
        }
    }

    /**
     * 进行字断过滤
     *
     * @param $mArray
     * @param $filter
     * @return array
     */
    private function arrayIntersect($mArray, $filter)
    {
        if (strstr($this->getFiled(), ".")) {
            return $this->depth($mArray, $filter);
        } else {
            return $this->shallow($mArray, $filter);
        }
    }

    /**
     * 浅度处理
     *
     * @param $mArray
     * @param $filter
     * @return array
     */
    private function shallow($mArray,$filter){
        return array_intersect_key($mArray, $filter);
    }


    /**
     * 深度处理
     *
     * @param $mArray
     * @param $filter
     * @return array
     */
    private function depth($mArray, $filter)
    {
        $smallfieldArr = $mArray;
        $resultFieldArr = [];
        foreach ($filter as $fieldName => $val) {
            $this->isIsCompletion() ? $this->autoCompletion($resultFieldArr, explode(".", $fieldName)): null;
            if (strstr($fieldName, ".")) {
                $this->impoStrForMarray($smallfieldArr, $fieldName, $resultFieldArr);
            } else {
                $this->setArrayVal($resultFieldArr, $fieldName, $smallfieldArr, $fieldName);
            }
        }

        return $resultFieldArr;
    }


    /**
     * 自动保存
     *
     * @param $resultFieldArr
     * @param $fieldArr
     */
    private function autoCompletion(&$resultFieldArr, $fieldArr)
    {
        $fieldName = $fieldArr[0];
        if(is_array($resultFieldArr) && array_key_exists($fieldName,$resultFieldArr)){
            //
        }else{
            $resultFieldArr[$fieldName] = $this -> getDefaultVal();
        }

        //删除数组项
        array_splice($fieldArr, 0, 1);
        if (count($fieldArr)) {
            $this->autoCompletion($resultFieldArr[$fieldName], $fieldArr);
        }
    }

    /**
     * 构建结构
     *
     * @param $resultFieldArr
     * @param $fieldName
     */
    private function generateTree(&$resultFieldArr, $fieldName)
    {
        $resultFieldArr[$fieldName] = $this->getDefaultVal();
    }


    /**
     * 处理带点的对象结构
     * @param $mArray
     * @param $filterStr
     */
    private function impoStrForMarray(&$mArray, $filterStr, &$resultFieldArr)
    {
        //如果对象不存在过滤的的字段就不作处理
        //如果处在就判断是否是存在子级别,不存在就进行过滤
        //存在子级就进行递归,直到不存在子级为止
        if ($mArray == null && $resultFieldArr == null)
            return;

        if (strstr($filterStr, ".")) {
            $filterArr = explode(".", $filterStr);
            $implofilterStr = $filterArr[0];
            //不存在属性 就返回,避免生成null 数据
            if (!array_key_exists($filterArr[0], $mArray)) {
                return;
            }
            unset($filterArr[0]);
            //递归
            $this->impoStrForMarray($mArray[$implofilterStr], implode(".", $filterArr), $resultFieldArr[$implofilterStr]);
        } else {
            //判断个体还是列表
            if (isset($mArray[0])) {
                if (is_array($mArray[0])) {
                    foreach ($mArray as $k => $v) {
                        $this->setArrayVal($resultFieldArr[$k], $filterStr, $v, $filterStr);
                    }
                } else {
                    $this->setArrayVal($resultFieldArr, $filterStr, $mArray, $filterStr);
                }
            } else {
                $this->setArrayVal($resultFieldArr, $filterStr, $mArray, $filterStr);
            }
        }
    }


    /**
     * 在数组中取的设置值
     *
     * @param $ia
     * @param $ik
     * @param $ca
     * @param $ck
     */
    function setArrayVal(&$ia, $ik, $ca, $ck)
    {
        if ($this->getArrayVal($ck, $ca, self::IS_NOT_IN_ARRAY) !== self::IS_NOT_IN_ARRAY) {
            $ia[$ik] = $this->getArrayVal($ck, $ca, "");
        }
    }


    /**
     * 在数组中取的值
     *
     * @param $key
     * @param $mArray
     * @param string $default
     * @return string
     */
    function getArrayVal($key, $mArray, $default = "")
    {
        if (array_key_exists($key, $mArray)) {
            return $mArray[$key];
        }
        return $default;
    }

    /**
     * 取得 filed 参数名字
     *
     * @return string
     */
    public function getFiled()
    {
        return $this->getArrayVal($this->getFiledName(), $_REQUEST, []);
    }

    /**
     * 设定 filed 参数名字
     *
     * @param string $filed
     */
    public function setFiled($filed)
    {
        $this->filed = $filed;
    }

    /**
     * 取得过滤字段名
     *
     * @return string
     */
    public function getFiledName()
    {
        return $this->filedName;
    }

    /**
     * 设置过滤字段名
     *
     * @param string $filedName
     */
    public function setFiledName($filedName)
    {
        $this->filedName = $filedName;
    }

    /**
     * @return boolean
     */
    public function isIsCompletion()
    {
        return $this->isCompletion;
    }

    /**
     * @param boolean $isCompletion
     */
    public function setIsCompletion($isCompletion)
    {
        $this->isCompletion = $isCompletion;
    }

    /**
     * @return string
     */
    public function getDefaultVal()
    {
        return $this->defaultVal;
    }

    /**
     * @param string $defaultVal
     */
    public function setDefaultVal($defaultVal)
    {
        $this->defaultVal = $defaultVal;
    }

}
