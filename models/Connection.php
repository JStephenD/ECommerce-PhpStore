<?php

class Connection {
    static function connect() {
        if (isset($_ENV['JAWSDB_URL'])) {
            $link = new PDO(
                "mysql:host=l0ebsc9jituxzmts.cbetxkdyhwsb.us-east-1.rds.amazonaws.com;dbname=b8km5t6m6l4mxo4u",
                "xvu0jilf06y7bwa8",
                "qgsl04kvg5ug653o"
            );
            $link->exec("set names utf8");
            return $link;
        } else {
            $link = new PDO("mysql:host=localhost;dbname=phpstore", "root", "");
            $link->exec("set names utf8");
            return $link;
        }
    }
}
