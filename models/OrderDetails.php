<?php


class OrderDetails {
    function __construct($db, $table = 'order_details') {
        $this->db = $db;
        $this->table = $table;
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                order_id,
                product_id,
                quantity
            )
            VALUES
            (
                :order_id,
                :product_id,
                :quantity
            )"
        );
        $query->execute($data);
        return $this->db->lastInsertId();
    }
}
