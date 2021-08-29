<?php

class Admins {
    function __construct($db, $table = 'admin') {
        $this->db = $db;
        $this->table = $table;
    }

    function login($data) {
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

    function get($id = null) {
    }
}
