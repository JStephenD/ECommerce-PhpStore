<?php

class Products {
    function __construct($db, $table = 'products') {
        $this->db = $db;
        $this->table = $table;
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                name,
                price,
                description,
                picture,
                category_id
            )
            VALUES
            (
                :name,
                :price,
                :description,
                :picture,
                :category_id
            )"
        );
        $query->execute($data);
        $query = null;
    }
}
