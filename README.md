# Product Management REST API

A modern PHP 8.x REST API for managing products, built with best practices and modern PHP features.

## Features

- RESTful API endpoints for CRUD operations on products
- PostgreSQL database integration
- Input validation using PHP Attributes
- Repository pattern implementation
- DTO (Data Transfer Object) usage
- Modern PHP 8.2+ features (Enums, readonly properties, etc.)

## Requirements

- PHP 8.2 or higher
- PostgreSQL
- Composer
- Docker (optional)

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd product-api
```

2. Install dependencies:
```bash
composer install
```

3. Create a `.env` file in the root directory with the following content:
```
DB_HOST=localhost
DB_PORT=5432
DB_NAME=product_api
DB_USER=postgres
DB_PASSWORD=postgres
APP_ENV=dev
APP_DEBUG=true
```

4. Create the database and table:
```bash
# Create the database
createdb product_api

# Create the products table
psql -d product_api -c "CREATE TABLE products (
    id UUID PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    attributes JSONB NOT NULL,
    created_at TIMESTAMP NOT NULL
);"
```

## Running with Docker

1. Build and start the containers:
```bash
docker-compose up -d
```

2. Access the API at `http://localhost:8080`

The Docker setup includes:
- PHP 8.2 with FPM
- Nginx web server
- PostgreSQL database

## API Endpoints

### Create a Product
- **POST** `/products`
- Request body:
```json
{
    "name": "Product Name",
    "price": 100.50,
    "category": "electronics",
    "attributes": {
        "brand": "Apple",
        "color": "black"
    }
}
```

### Get Product Details
- **GET** `/products/{id}`

### Update Product
- **PATCH** `/products/{id}`
- Request body (partial update):
```json
{
    "price": 150.00,
    "attributes": {
        "color": "white"
    }
}
```

### Delete Product
- **DELETE** `/products/{id}`

### List Products
- **GET** `/products`
- Query parameters:
  - `category` (optional): Filter by category
  - `maxPrice` (optional): Filter by maximum price

## Development

The project follows PSR-4 autoloading standards and is structured as follows:

```
src/
├── Config/         # Configuration classes
├── Controller/     # API controllers
├── Entity/         # Domain entities
├── Repository/     # Data access layer
├── Service/        # Business logic
└── DTO/            # Data Transfer Objects
```

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details. 