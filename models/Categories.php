<?php

class Categories {
    function __construct($db, $table = 'categories') {
        $this->db = $db;
        $this->table = $table;
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                name
            )
            VALUES
            (
                :name
            )"
        );
        $query->execute($data);
        $query = null;
    }

    function get($id = null) {
        if (isset($id)) {
            $query = $this->db->prepare("Select * From $this->table Where id = :id");
            $query->execute(["id" => $id]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = $this->db->prepare("Select * From $this->table");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }
}
