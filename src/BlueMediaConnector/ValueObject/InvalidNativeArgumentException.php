<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 12:58
 */

namespace BlueMediaConnector\ValueObject;


class InvalidNativeArgumentException extends \InvalidArgumentException
{
    /**
     * @var string
     */
    private $errorCode;

    /**
     * InvalidNativeArgumentException constructor.
     * @param string $message
     * @param string $errorCode
     */
    public function __construct($message, $errorCode)
    {
        parent::__construct($message);
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->errorCode;
    }
}