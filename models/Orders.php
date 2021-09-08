<?php


class Orders {
    function __construct($db, $table = 'orders') {
        $this->db = $db;
        $this->table = $table;
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                customer_id,
                address,
                phone,
                total
            )
            VALUES
            (
                :customer_id,
                :address,
                :phone,
                :total
            )
            "
        );
        $query->execute($data);
        return $this->db->lastInsertId();
    }
}
