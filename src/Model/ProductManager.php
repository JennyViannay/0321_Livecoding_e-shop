<?php

namespace App\Model;

/**
 *
 */
class ProductManager extends AbstractManager
{
    public const TABLE = 'product';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAll(): array
    {
        return $this->pdo->query('SELECT product.id,
        title, description, price, qty, category_id, category.name as category_name
        FROM product
        JOIN category ON category.id = product.category_id')->fetchAll();
    }

    public function selectOneById(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT product.id,
        title, description, price, qty, category_id, category.name as category_name
        FROM product 
        JOIN category ON category.id = product.category_id
        WHERE product.id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }

    /**
     * @param array $product
     * @return int
     */
    public function insert(array $product): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`title`, `description`, `price`, `qty`, `category_id`) 
        VALUES (:title, :description, :price, :qty, :category_id)");
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('qty', $product['qty'], \PDO::PARAM_INT);
        $statement->bindValue('category_id', $product['category_id'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }


    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }


    /**
     * @param array $product
     * @return bool
     */
    public function update(array $product): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `title` = :title, `description` = :description,
        `price` = :price, `qty` = :qty, `category_id` = :category_id
        WHERE id=:id");
        $statement->bindValue('id', $product['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $product['title'], \PDO::PARAM_STR);
        $statement->bindValue('description', $product['description'], \PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], \PDO::PARAM_INT);
        $statement->bindValue('qty', $product['qty'], \PDO::PARAM_INT);
        $statement->bindValue('category_id', $product['category_id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
