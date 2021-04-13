<?php

namespace App\Model;

/**
 *
 */
class OrderManager extends AbstractManager
{
    public const TABLE = 'order';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $order
     * @return int
     */
    public function insert(array $order): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`created_at`,`total`,`user_id`) VALUES (:created_at, :total, :user_id)");
        $statement->bindValue('created_at', $order['created_at']);
        $statement->bindValue('total', $order['total'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $order['user_id'], \PDO::PARAM_INT);

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
     * @param array $order
     * @return bool
     */
    public function update(array $order): bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
        " SET `created_at` = :created_at, `total` = :total, `user_id` = :user_id 
        WHERE id=:id");
        $statement->bindValue('id', $order['id'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $order['created_at']);
        $statement->bindValue('total', $order['total'], \PDO::PARAM_INT);
        $statement->bindValue('user_id', $order['user_id'], \PDO::PARAM_INT);

        return $statement->execute();
    }
}
