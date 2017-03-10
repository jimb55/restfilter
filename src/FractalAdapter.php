<?php

namespace Jimb\RestFilter;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Jimb\RestFilter\CommonTransformer;


class FractalAdapter
{
    public $fractal;

    private static $_instance = null;

    private $dataType;

    public $data;

    private $transformer;


    public function __construct($data = null)
    {
        $this->data = $data;
        $this->fractal = new Manager();
    }


    /**
     * 返回 JSON 数据
     *
     * @param array $data
     */
    public function toJson(Array $data)
    {
        if ($data) {
            $this->data = $data;
        }
        $this->dataType->setData($data);
        $this->dataType->setTransformer($this->getTransformer());
        return $this->fractal->createData($this->getDataType())->toJson();
    }

    /**
     * 设置 collection
     *
     * @return FractalAdapter
     */
    public function collection()
    {
        $this->dataType = new Collection();
        return $this;
    }

    /**
     * 设置 item
     *
     * @return FractalAdapter
     */
    public function item()
    {
        $this->dataType = new Item();
        return $this;
    }

    /**
     * 取得  SELF  实例
     *
     * @return Manager
     */
    static public function getInstance()
    {
        if (is_null(self::$_instance) || isset (self::$_instance)) {
            self::$_instance = new self ();
        }
        return self::$_instance;
    }



    /**
     * @return mixed
     */
    public function getDataType()
    {

        return $this->dataType;
    }

    /**
     * @param mixed $dataType
     */
    public function setDataType($dataType)
    {
        $this->dataType = $dataType;
    }


    /**
     * @return mixed
     */
    public function getFractal()
    {
        return $this->fractal;
    }

    /**
     * @param Manager $fractal
     */
    public function setFractal(Manager $fractal)
    {
        $this->fractal = $fractal;
    }

    /**
     * @return mixed
     */
    public function getTransformer()
    {
        if (!$this->transformer) {
            $this->transformer = new CommonTransformer;
        }
        return $this->transformer;
    }

    /**
     * @param mixed $transformer
     */
    public function setTransformer($transformer)
    {
        $this->transformer = $transformer;
    }

}
