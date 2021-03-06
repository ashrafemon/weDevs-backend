<?php

namespace app\Models;

use app\Core\Database;

class User
{
    private string $table = "users";
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

    public function findByEmail($email)
    {
        $statement = "SELECT * FROM $this->table WHERE email = ?;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array($email));
            return $statement->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function find($id)
    {
        $statement = "SELECT * FROM $this->table WHERE id = ?;";
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
        $statement = "INSERT INTO $this->table (name, email, password) VALUES (:name, :email, :password);";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_BCRYPT)
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "UPDATE person SET name = :name, email  = :email,password = :password WHERE id = :id;";
        try {
            $statement = $this->conn->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => password_hash($input['password'], PASSWORD_BCRYPT),
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