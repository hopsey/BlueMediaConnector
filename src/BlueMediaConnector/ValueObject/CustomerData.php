<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 12:18
 */

namespace BlueMediaConnector\ValueObject;


use BlueMediaConnector\Hydrator\StaticHydrator;
use BlueMediaConnector\Hydrator\ValueObject;
use BlueMediaConnector\ValueObject\StringValue;

class CustomerData implements ValueObjectInterface
{
    public static function fromNative()
    {
        throw new \BadMethodCallException("Not implemented");
    }

    public function toNative()
    {
        return StaticHydrator::extract(ValueObject::class, $this);
    }

    public function __toString()
    {
        throw new \BadMethodCallException("Not implemented");
        return "";
    }


    /**
     * @var StringValue|null
     */
    protected $fName = null;

    /**
     * @var StringValue|null
     */
    protected $lName = null;

    /**
     * @var StringValue|null
     */
    protected $streetName = null;

    /**
     * @var StringValue|null
     */
    protected $streetHouseNo = null;

    /**
     * @var StringValue|null
     */
    protected $streetStaircaseNo = null;

    /**
     * @var StringValue|null
     */
    protected $streetPremiseNo = null;

    /**
     * @var StringValue|null
     */
    protected $postalCode = null;

    /**
     * @var StringValue|null
     */
    protected $city = null;

    /**
     * @var StringValue|null
     */
    protected $nrb = null;

    /**
     * CustomerData constructor.
     * @param StringValue|null $fName
     * @param StringValue|null $lName
     * @param StringValue|null $streetName
     * @param StringValue|null $streetHouseNo
     * @param StringValue|null $streetStaircaseNo
     * @param StringValue|null $streetPremiseNo
     * @param StringValue|null $postalCode
     * @param StringValue|null $city
     * @param StringValue|null $nrb
     */
    public function __construct(StringValue $fName = null, StringValue $lName = null, StringValue $streetName = null,
        StringValue $streetHouseNo = null, StringValue $streetStaircaseNo = null, StringValue $streetPremiseNo = null,
        StringValue $postalCode = null, StringValue $city = null, StringValue $nrb = null)
    {
        $this->fName = $fName;
        $this->lName = $lName;
        $this->streetName = $streetName;
        $this->streetHouseNo = $streetHouseNo;
        $this->streetStaircaseNo = $streetStaircaseNo;
        $this->streetPremiseNo = $streetPremiseNo;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->nrb = $nrb;
    }


}