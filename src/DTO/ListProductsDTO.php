<?php

namespace Suziria\ProductApi\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class ListProductsDTO
{
    #[Assert\Length(min: 3, max: 100)]
    public readonly ?string $category;
    
    #[Assert\Positive]
    public readonly ?float $maxPrice;

    public function __construct(
        ?string $category = null,
        ?float $maxPrice = null
    ) {
        $this->category = $category;
        $this->maxPrice = $maxPrice;
    }

    public static function fromRequest(array $query): self
    {
        return new self(
            $query['category'] ?? null,
            isset($query['maxPrice']) ? (float) $query['maxPrice'] : null
        );
    }
} 