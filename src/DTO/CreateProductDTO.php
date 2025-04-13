<?php

namespace Suziria\ProductApi\DTO;

use Symfony\Component\Validator\Constraints as Assert;

class CreateProductDTO extends ProductDTO
{
    public static function fromRequest(array $data): self
    {
        return new self(
            $data['name'] ?? '',
            $data['price'] ?? 0,
            $data['category'] ?? '',
            $data['attributes'] ?? []
        );
    }
} 