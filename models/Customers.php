<?php

class Customers {
    function __construct($db, $table = 'customers') {
        $this->db = $db;
        $this->table = $table;
    }

    function login($data) {
        if (!$this->checkUserExist($data['username'])) {
            return "userNotFound";
        }

        $query = $this->db->prepare(
            "SELECT 
                id,
                username
            FROM $this->table 
            WHERE
                username = :username AND
                password = :password
            "
        );
        $query->execute($data);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            unset($result['password']);
            return $result;
        } else {
            return 'incorrectPassword';
        }
    }

    function register($data) {
        if ($this->checkUserExist($data['username'])) {
            return "userExists";
        }

        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                username,
                password
            )
            VALUES
            (
                :username,
                :password
            )"
        );
        if ($query->execute($data)) {
            return "success";
        } else {
            return "unsucessful";
        }
    }

    function checkUserExist($username) {
        $query = $this->db->prepare(
            "SELECT
                username
            FROM $this->table 
            WHERE
                username = :username
            "
        );
        $query->execute(["username" => $username]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return count($result) != 0;
    }

    function get($id = null) {
    }
}
