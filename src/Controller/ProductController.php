<?php

namespace Suziria\ProductApi\Controller;

use Suziria\ProductApi\Entity\Product;
use Suziria\ProductApi\Repository\ProductRepository;
use Suziria\ProductApi\DTO\CreateProductDTO;
use Suziria\ProductApi\DTO\UpdateProductDTO;
use Suziria\ProductApi\DTO\ListProductsDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ProductController
{
    public function __construct(private ProductRepository $repository, private ValidatorInterface $validator)
    {}

    public function create(Request $request): JsonResponse
    {
        $dto = CreateProductDTO::fromRequest(json_decode($request->getContent(), true));
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $product = new Product(
            $dto->name,
            $dto->price,
            $dto->category,
            $dto->attributes
        );

        $this->repository->save($product);

        return new JsonResponse($product->toArray(), Response::HTTP_CREATED);
    }

    public function get(string $id): JsonResponse
    {
        $product = $this->repository->find($id);
        
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($product->toArray());
    }

    public function update(string $id, Request $request): JsonResponse
    {
        $product = $this->repository->find($id);
        
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $dto = UpdateProductDTO::fromRequest(json_decode($request->getContent(), true));
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $this->repository->update($id, $dto->toArray());

        return new JsonResponse(['message' => 'Product updated successfully']);
    }

    public function delete(string $id): JsonResponse
    {
        $product = $this->repository->find($id);
        
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $this->repository->delete($id);

        return new JsonResponse(['message' => 'Product deleted successfully']);
    }

    public function list(Request $request): JsonResponse
    {

        $dto = ListProductsDTO::fromRequest($request->query->all());
        
        $errors = $this->validator->validate($dto);
        if (count($errors) > 0) {
            return new JsonResponse(['errors' => (string) $errors], Response::HTTP_BAD_REQUEST);
        }

        $products = $this->repository->findAll($dto->category, $dto->maxPrice);

        return new JsonResponse(array_map(fn($product) => $product->toArray(), $products));
    }
} 