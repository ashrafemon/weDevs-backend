<?php


namespace app\Models;


use app\Core\Database;

class Category
{
    private string $table = "categories";
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
        $statement = "INSERT INTO $this->table (name) VALUES (:name);";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('name' => $input['name']));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "UPDATE $this->table SET name = :name WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array('id' => (int)$id, 'name' => $input['name']));
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