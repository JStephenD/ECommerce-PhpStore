<?php

class Products {
    function __construct($db, $table = 'products') {
        $this->db = $db;
        $this->table = $table;
    }

    function get($id = 0) {
        if ($id == 0) {
            $query = $this->db->prepare("SELECT * FROM $this->table");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $query = $this->db->prepare(
                "
                SELECT * FROM $this->table WHERE id = :id"
            );
            $query->execute(['id' => $id]);
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    function add($data) {
        $query = $this->db->prepare(
            "INSERT INTO 
            $this->table(
                name,
                price,
                description,
                picture,
                tag,
                category_id
            )
            VALUES
            (
                :name,
                :price,
                :description,
                :picture,
                :tag,
                :category_id
            )"
        );
        $query->execute($data);
        $query = null;
    }

    function update($data) {
        $query = $this->db->prepare(
            "UPDATE $this->table SET
                name = :name,
                price = :price,
                description = :description,
                picture = :picture,
                tag = :tag,
                category_id = :category_id
            WHERE id = :id"
        );
        $query->execute($data);
        $query = null;
    }

    function delete($data) {
        $query = $this->db->prepare(
            "DELETE FROM $this->table WHERE id = :id"
        );
        $query->execute($data);
        $query = null;
    }

    function get_tags() {
        $query = $this->db->prepare("SELECT DISTINCT tag FROM $this->table");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
