<?php

namespace app\Models;

use app\Core\Database;

class Order
{
    private string $table = "orders";
    private Database $db;
    private \PDO $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    public function all()
    {
        $statement = "SELECT * FROM $this->table;";
        try {
            $statement = $this->conn->query($statement);
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "SELECT * FROM $this->table WHERE id = ? LIMIT 1;";
        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "INSERT INTO $this->table (user_id, product_id, quantity, price, status) VALUES (:use_id, :product_id, :quantity, :price, :status);";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'user_id' => $input['user_id'],
                'product_id' => $input['product_id'],
                'quantity' => $input['quantity'],
                'price' => $input['price'],
                'status' => $input['status'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "UPDATE $this->table SET user_id = :user_id,product_id = :product_id,quantity = :quantity,price = :price, status = :status WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'user_id' => $input['user_id'],
                'product_id' => $input['product_id'],
                'quantity' => $input['quantity'],
                'price' => $input['price'],
                'status' => $input['status'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function delete($id)
    {
        $statement = "DELETE FROM $this->table WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('id' => (int)$id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}