<?php

namespace App\Entity;


class ModelFactory
{


    /**
     * 
     * @param string $className 
     * @param array $attributes 
     * @return Entity
     */
    static public function create(string $className, array $attributes = [])
    {
        $class = new $className;
        foreach ($attributes as $attribute => $value) {
            $method = 'set' . ucfirst($attribute);
            $class->$method($value);
        }
        return $class;
    }
    /**
     * 
     * @param string $className 
     * @param array $attributes 
     * @return Entity[]
     */
    static public function createArray(string $className, array $attributes = [])
    {
        $array = [];
        foreach($attributes as $item){
            $array[] = self::create($className,$item);
        }
        return $array;
    }
}
