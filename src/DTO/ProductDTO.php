<?php

namespace Suziria\ProductApi\DTO;

use Symfony\Component\Validator\Constraints as Assert;

abstract class ProductDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    public readonly string $name;
    
    #[Assert\NotBlank]
    #[Assert\Positive]
    public readonly float $price;
    
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 100)]
    public readonly string $category;
    
    #[Assert\Type('array')]
    public readonly array $attributes;

    public function __construct(
        string $name,
        float $price,
        string $category,
        array $attributes = []
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }
} 