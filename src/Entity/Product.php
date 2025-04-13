<?php

namespace Suziria\ProductApi\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Ramsey\Uuid\Uuid;

class Product
{
    public readonly string $id;
    
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
    
    public readonly \DateTimeImmutable $createdAt;

    public function __construct(
        string $name,
        float $price,
        string $category,
        array $attributes = []
    ) {
        $this->id = Uuid::uuid4()->toString();
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'category' => $this->category,
            'attributes' => $this->attributes,
            'createdAt' => $this->createdAt->format('c')
        ];
    }
} 