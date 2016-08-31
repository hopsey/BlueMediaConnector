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

class HashFactory implements HashFactoryInterface
{
    const ERR_NO_PARAMETERS = 'noParameters';
    const ERR_INVALID_PARAMETERS = 'invalidParameters';
    const ERR_INVALID_PARAMETER = 'invalidParameter';

    /**
     * @var AlgoInterface
     */
    private $algo;

    /**
     * @var StringValue
     */
    private $secret;

    /**
     * @var string
     */
    private $separator;

    /**
     * HashFactory constructor.
     * @param StringValue $secret
     * @param string $separator
     * @param AlgoInterface|null $algo
     */
    public function __construct(StringValue $secret, $separator = "|", AlgoInterface $algo = null)
    {
        // domyslny algo
        $this->algo = $algo ?: new Sha256();
        $this->secret = $secret;
        $this->separator = $separator;
    }

    /**
     * @param AlgoInterface $algo
     */
    public function setAlgo(AlgoInterface $algo)
    {
        $this->algo = $algo;
    }

    /**
     * metoda buduje hash. Jesli nie podano parametru algo, skrypt automatycznie uzyje domyslnego algorytmu.
     * @param Hash\ArgsTransport\ArgsTransportInterface $args
     * @return Hash
     */
    public function build(Hash\ArgsTransport\ArgsTransportInterface $args)
    {
        if (count($args) == 0) {
            throw new InvalidNativeArgumentException("No parameters to generate hash!", self::ERR_NO_PARAMETERS);
        }

        $concatArray = [];

        foreach ($args->toArray() as $key => $value) {
            $concatArray[$key] = (string)$value;
        }

        $concatArray[] = $this->secret->toNative();

        return new Hash($this->algo->hash(implode($this->separator, $concatArray)));
    }
}