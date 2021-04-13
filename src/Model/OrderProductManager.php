<?php

namespace App\Model;

/**
 *
 */
class OrderProductManager extends AbstractManager
{
    public const TABLE = 'order_product';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $orderProduct
     * @return int
     */
    public function insert(array $orderProduct): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE .
        " (`order_id`,`product_id`,`qty`) VALUES (:order_id, :product_id, :qty)");
        $statement->bindValue('order_id', $orderProduct['order_id'], \PDO::PARAM_INT);
        $statement->bindValue('product_id', $orderProduct['product_id'], \PDO::PARAM_INT);
        $statement->bindValue('qty', $orderProduct['qty'], \PDO::PARAM_INT);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
