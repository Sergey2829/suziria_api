<?php

namespace Suziria\ProductApi\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class UpdateProductDTO
{
    #[Assert\Length(min: 3, max: 255)]
    public readonly ?string $name;
    
    #[Assert\Positive]
    public readonly ?float $price;
    
    #[Assert\Length(min: 3, max: 100)]
    public readonly ?string $category;
    
    #[Assert\Type('array')]
    public readonly ?array $attributes;

    public function __construct(
        ?string $name = null,
        ?float $price = null,
        ?string $category = null,
        ?array $attributes = null
    ) {
        $this->name = $name;
        $this->price = $price;
        $this->category = $category;
        $this->attributes = $attributes;
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['price'] ?? null,
            $data['category'] ?? null,
            $data['attributes'] ?? null
        );
    }

    public function toArray(): array
    {
        $data = [];
        
        if ($this->name !== null) {
            $data['name'] = $this->name;
        }
        
        if ($this->price !== null) {
            $data['price'] = $this->price;
        }
        
        if ($this->category !== null) {
            $data['category'] = $this->category;
        }
        
        if ($this->attributes !== null) {
            $data['attributes'] = $this->attributes;
        }
        
        return $data;
    }
} 