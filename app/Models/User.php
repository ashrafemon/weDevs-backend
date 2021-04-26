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

    public function find($id)
    {
        $statement = "SELECT * FROM person WHERE id = ?;";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array($id));
            return $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function insert(array $input)
    {
        $statement = "
            INSERT INTO person 
                (firstname, lastname, firstparent_id, secondparent_id)
            VALUES
                (:firstname, :lastname, :firstparent_id, :secondparent_id);
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
            ));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    public function update($id, array $input)
    {
        $statement = "
            UPDATE person
            SET 
                firstname = :firstname,
                lastname  = :lastname,
                firstparent_id = :firstparent_id,
                secondparent_id = :secondparent_id
            WHERE id = :id;
        ";

        try {
            $statement = $this->db->prepare($statement);
            $statement->execute(array(
                'id' => (int)$id,
                'firstname' => $input['firstname'],
                'lastname' => $input['lastname'],
                'firstparent_id' => $input['firstparent_id'] ?? null,
                'secondparent_id' => $input['secondparent_id'] ?? null,
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
            $statement = $this->db->prepare($statement);
            $statement->execute(array('id' => $id));
            return $statement->rowCount();
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }
}