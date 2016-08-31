<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:55
 */

namespace BlueMediaConnector\ValueObject;


/**
 * Prosta cecha skupiająca storage i obsługe prostych typow ValueObjects
 * @package BlueMediaConnector\ValueObject
 */
trait SimpleValueObjectTrait
{
    /**
     * @var mixed
     */
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * @return static
     */
    public static function fromNative()
    {
        $value = \func_get_arg(0);
        return new static($value);
    }

    /**
     * @return mixed
     */
    public function toNative()
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return (string)$this->toNative();
    }
}