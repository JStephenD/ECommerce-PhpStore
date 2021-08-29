<?php

class Contact {
    function __construct($db, $table = 'contact') {
        $this->db = $db;
        $this->table = $table;
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                email,
                message
            )
            VALUES
            (
                :email, 
                :message
            )"
        );
        $query->execute($data);
        $query = null;
    }
}
