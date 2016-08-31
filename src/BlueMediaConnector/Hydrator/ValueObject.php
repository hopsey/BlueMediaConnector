<?php
/**
 * Created by PhpStorm.
 * User: tomaszchmielewski
 * Date: 31/08/16
 * Time: 12:36
 */

namespace BlueMediaConnector\Hydrator;


use BlueMediaConnector\ValueObject\ValueObjectInterface;

class ValueObject implements HydratorInterface
{
    /**
     * @var array
     */
    private static $cachedReflections = [];

    /**
     * @param string $className
     * @return array
     */
    private static function getCachedReflection($className)
    {
        if (!array_key_exists($className, self::$cachedReflections)) {
            $reflection = new \ReflectionClass($className);
            self::$cachedReflections[$className] = [
                'class' => $reflection,
                'properties' => $reflection->getProperties(),
                'constructor' => $reflection->getConstructor()
            ];
        }
        return self::$cachedReflections[$className];
    }

    /**
     * @param $className
     * @return \ReflectionProperty[]
     */
    private static function getCachedProperties($className)
    {
        return self::getCachedReflection($className)['properties'];
    }

    /**
     * @param $className
     * @return \ReflectionMethod
     */
    private static function getCachedConstructor($className)
    {
        return self::getCachedReflection($className)['constructor'];
    }

    /**
     * @param $className
     * @return \ReflectionClass
     */
    private static function getCachedClass($className)
    {
        return self::getCachedReflection($className)['class'];
    }

    /**
     * @param $object
     * @return array
     */
    public function extract($object)
    {
        $properties = self::getCachedProperties(get_class($object));
        $extractArray = [];

        foreach ($properties as $property) {
            $property->setAccessible(true);

            $name = $property->getName();
            $value = $property->getValue($object);
            if (is_object($value) && $value instanceof ValueObjectInterface) {
                $extractArray[$name] = $value->toNative();
            }
        }

        return $extractArray;
    }

    public function hydrate($object, $data)
    {
        // na razie nie ma potrzeby
        throw new \RuntimeException("Not implemented");
    }

    public function build($class, $data)
    {
        $constructor = self::getCachedConstructor($class);
        $params = $constructor->getParameters();
        $invokeParams = [];
        if (count($params) > 0) {
            foreach ($params as $param) {
                $paramName = $param->getName();
                $notRequired = $param->isDefaultValueAvailable() && $param->getDefaultValue() === null;
                $supplyParam = array_key_exists($paramName, $data) ? $data[$paramName] : null;
                if ($supplyParam !== null) {
                    $paramType = ($param->getType() === null ? null : (string)$param->getType());
                    if (null === $paramType || (is_object($supplyParam) && get_class($supplyParam) == $paramType)) {
                        $invokeParams[] = $supplyParam;
                        continue;
                    }
                    $invokeParams[] = $paramType::fromNative($supplyParam);
                    continue;
                } else {
                    if ($notRequired) {
                        $invokeParams[] = null;
                        continue;
                    }
                    throw new \InvalidArgumentException("Param " . $paramName . " required and not supplied");
                }
            }
        }
        return self::getCachedClass($class)->newInstanceArgs($invokeParams);
    }
}