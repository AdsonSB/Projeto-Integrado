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

    public function list(): array
    {
        $sql = 'SELECT * FROM products';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        // Obtendo todos os Resultados.
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Convertendo os resultados para instâncias da classe Product.
        $products = [];
        foreach ($result as $row) {
            $product[] = new Product();
            $product->setId($row['product_id']);
            $product->description = $row['description'];
            $product->name = $row['name'];
            $product->price = $row['price'];
            $product->quantity = $row['quantity'];
            $products[] = $product;
        }
        return $products;
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

    /**
     * @return Product[]
     */

    public function all(): array
    {
        $productList = $this->pdo
            ->query('SELECT * FROM products')
            ->fetchAll(PDO::FETCH_ASSOC);

        // Se hydrateProduct é um método da classe, use-o como callback
        return array_map([$this, 'hydrateProduct'], $productList);
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





}