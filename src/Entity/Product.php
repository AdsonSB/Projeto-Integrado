<?php

namespace Senac\Mvc\Entity;

class Product
{
    public readonly int $id;
    public readonly string $description;
    public readonly string $price;
    public readonly string $name;
    public readonly string $category;
    public readonly string $quantity;

    function __construct($description, $price, $name, $category, $quantity)
    {
        $this->description = $description;
        $this->price = $price;
        $this->name = $name;
        $this->category = $category;
        $this->quantity = $quantity;
    }



    /**
     *@param int $id
     */
    public function setId(int $id): void{
        $this->id = $id;
    }
}