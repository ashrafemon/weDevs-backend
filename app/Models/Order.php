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
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($id));
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input, $user)
    {
        $statement = "INSERT INTO $this->table 
                                (invoice_id, user_id, user_name, user_email, product_id, product_name, shipping_address, quantity, price) 
                        VALUES  (:invoice_id,:user_id, :user_name, :user_email, :product_id, :product_name, :shipping_address, :quantity, :price);";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'invoice_id' => strtoupper(uniqid('INVOICE_')),
                'user_id' => (int)$user['id'],
                'user_name' => $user['name'],
                'user_email' => $user['email'],
                'product_id' => (int)$input['product_id'],
                'product_name' => $input['product_name'],
                'shipping_address' => $input['shipping_address'],
                'quantity' => $input['quantity'],
                'price' => $input['price'],
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input, $order)
    {
        $statement = "UPDATE $this->table SET quantity = :quantity,price = :price, status = :status WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'quantity' => $input['quantity'] ?? $order['quantity'],
                'price' => $input['price'] ?? $order['price'],
                'status' => $input['status'] ?? $order['status'],
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