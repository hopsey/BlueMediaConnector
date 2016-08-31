<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 30/08/16
 * Time: 13:14
 */

namespace BlueMediaConnector\ValueObject\Hash;


use BlueMediaConnector\ValueObject\Hash;
use BlueMediaConnector\ValueObject\Hash\Algo\AlgoInterface;
use BlueMediaConnector\ValueObject\Hash\Algo\Sha256;
use BlueMediaConnector\ValueObject\InvalidNativeArgumentException;
use BlueMediaConnector\ValueObject\StringValue;
use BlueMediaConnector\ValueObject\ValueObjectInterface;

class HashFactory
{
    const ERR_NO_PARAMETERS = 'noParameters';
    const ERR_INVALID_PARAMETERS = 'invalidParameters';
    const ERR_INVALID_PARAMETER = 'invalidParameter';

    private static $algo;

    /**
     * @return AlgoInterface
     */
    private static function getHashAlgo()
    {
        if (null === self::$algo) {
            // domyslny algo - zgodny z BM
            self::$algo = new Sha256();
        }
        return self::$algo;
    }

    /**
     * @param AlgoInterface $algo
     */
    public static function setHashAlgo(AlgoInterface $algo)
    {
        self::$algo = $algo;
    }

    /**
     * metoda buduje hash. Jesli nie podano parametru algo, skrypt automatycznie uzyje domyslnego algorytmu.
     * @param Hash\ArgsTransport\ArgsTransportInterface $args
     * @param string $separator
     * @param AlgoInterface|null $algo
     * @return Hash $hash
     */
    public static function build(Hash\ArgsTransport\ArgsTransportInterface $args, StringValue $secret, $separator = "|", AlgoInterface $algo = null)
    {
        if (count($args) == 0) {
            throw new InvalidNativeArgumentException("No parameters to generate hash!", self::ERR_NO_PARAMETERS);
        }

        $concatArray = [];

        foreach ($args as $key => $value) {
            if (!$value instanceof ValueObjectInterface) {
                throw new InvalidNativeArgumentException("All parameters must implement " .
                    ValueObjectInterface::class, self::ERR_INVALID_PARAMETERS);
            }
            $concatArray[$key] = $value->toNative();
        }

        $concatArray[] = $secret->toNative();

        $algo = $algo ?: self::getHashAlgo();

        return new Hash($algo->hash(implode($separator, $concatArray)));
    }
}