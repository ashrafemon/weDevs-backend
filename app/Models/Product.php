<?php

namespace app\Models;

use app\Core\Database;

class Product
{
    private string $table = "products";
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

    public function insert(array $input)
    {
        $statement = "INSERT INTO $this->table (name, sku, description, category_id, price, image) VALUES (:name, :sku, :description, :category_id, :price, :image);";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'sku' => $input['sku'],
                'description' => $input['description'],
                'category_id' => $input['category_id'],
                'price' => $input['price'],
                'image' => $input['image'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "UPDATE $this->table SET name = :name,description = :description,category_id = :category_id,price = :price, image = :image WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'name' => $input['name'],
                'description' => $input['description'],
                'category_id' => $input['category_id'],
                'price' => $input['price'],
                'image' => $input['image'] ?? null,
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