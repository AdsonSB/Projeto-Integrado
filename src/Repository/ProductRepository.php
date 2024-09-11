<?php

namespace Senac\Mvc\Repository;
use PDO;
use Senac\Mvc\Entity\Product;

class ProductRepository
{
    public function __construct(private PDO $pdo)
    {
    }


    //Função para adicionar os produtos.
    public function add(Product $product) : bool
    {
        $sql = 'INSERT INTO products (description, name, price, quantity) VALUES(?, ?, ?, ?)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $product->description);
        $stmt->bindValue(2, $product->name);
        $stmt->bindValue(3, $product->price);
        $stmt->bindValue(4, $product->quantity);

        $result = $stmt->execute();
        $id = $this->pdo->lastInsertId();

        $product->setId($id);
        return $result;
    }
    /**
     * @return Product[]
     */
    public function all(): array
    {
        $productList = $this->pdo->query("SELECT * FROM products")->fetchAll(\PDO::FETCH_ASSOC);
        return array_map($this->hydrateProduct(...), $productList);
    }
    public function update(Product $product) : bool
    {
        $sql = 'UPDATE product SET description = ?, name = ?, price = ?, quantity = ? WHERE product_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $product->description);
        $stmt->bindValue(2, $product->name);
        $stmt->bindValue(3, $product->price);
        $stmt->bindValue(4, $product->quantity);
        $stmt->bindValue(5, $product->id);

        $result = $stmt->execute();
        return $result;
    }

    public function find(int $id)
    {
        // Preparar a consulta SQL pra buscar um produto pelo ID
        $sql = 'SELECT * FROM products WHERE id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        return $this->hydrateProduct($stmt->fetch(\PDO::FETCH_ASSOC));
    }
    public function hydrateProduct(Product $product): Product
    {

        $product = new Product($product['description'],
            $product['name'],
            $product['price'],
            $product['quantity']);
        $product->setId($product['id']);

        return $product;
    }

    public function remove(int $id) : bool
    {
        $sql = 'DELETE FROM products WHERE product_id = ?';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);

        return $stmt->execute();
    }



}