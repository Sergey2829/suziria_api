<?php

namespace Suziria\ProductApi\Repository;

use Suziria\ProductApi\Entity\Product;
use Suziria\ProductApi\Config\Database;
use Doctrine\DBAL\Connection;

class ProductRepository
{
    private Connection $connection;

    public function __construct()
    {
        $this->connection = Database::getInstance()->getConnection();
    }

    public function save(Product $product): void
    {
        $this->connection->insert('products', [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'category' => $product->category,
            'attributes' => json_encode($product->attributes),
            'created_at' => $product->createdAt->format('Y-m-d H:i:s')
        ]);
    }

    public function find(string $id): ?Product
    {
        $result = $this->connection->fetchAssociative(
            'SELECT * FROM products WHERE id = ?',
            [$id]
        );

        if (!$result) {
            return null;
        }

        return new Product(
            $result['name'],
            (float) $result['price'],
            $result['category'],
            json_decode($result['attributes'], true)
        );
    }

    public function update(string $id, array $data): void
    {
        if (isset($data['attributes'])) {
            $data['attributes'] = json_encode($data['attributes']);
        }

        $this->connection->update('products', $data, ['id' => $id]);
    }

    public function delete(string $id): void
    {
        $this->connection->delete('products', ['id' => $id]);
    }

    public function findAll(?string $category = null, ?float $maxPrice = null): array
    {
        $query = 'SELECT * FROM products WHERE 1=1';
        $params = [];

        if ($category !== null) {
            $query .= ' AND category = ?';
            $params[] = $category;
        }

        if ($maxPrice !== null) {
            $query .= ' AND price <= ?';
            $params[] = $maxPrice;
        }

        $results = $this->connection->fetchAllAssociative($query, $params);

        return array_map(function ($result) {
            return new Product(
                $result['name'],
                (float) $result['price'],
                $result['category'],
                json_decode($result['attributes'], true)
            );
        }, $results);
    }
} 