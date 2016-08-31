<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 23:07
 */

namespace BlueMediaConnector\ValueObject;


class DateTime implements ValueObjectInterface
{
    /**
     * @var \DateTime
     */
    protected $dateTime;

    /**
     * @return DateTime
     */
    public static function fromNative()
    {
        return new static(@\func_get_arg(0));
    }

    public function __construct($value = null)
    {
        $this->dateTime = new \DateTime($value ?: "now");
    }

    /**
     * @return string
     */
    public function toNative()
    {
        return $this->dateTime->format("Y-m-d H:i:s");
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->toNative();
    }

}