<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 14:54
 */

namespace BlueMediaConnector\ValueObject\Hash\ArgsTransport;


use BlueMediaConnector\ValueObject\Hash;

/**
 * Implementacje tego interfejsu wstrzykiwane sa do klasy budujacej hash. Glownym zadaniem obiektu
 * implementujacego interfejs jest ustawienie parametrow w odpowiedniej dla danej wiadomosci kolejnosci i
 * zwrocenie w postaci tablicy jednowymiarowej.
 * @package BlueMediaConnector\ValueObject\Hash\ArgsTransport
 */
interface ArgsTransportInterface extends \ArrayAccess, \Countable
{
    /**
     * @return array
     */
    public function toArray();
}