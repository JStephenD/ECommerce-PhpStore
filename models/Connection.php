<?php

class Connection {
    static function connect() {
        if (
            isset($_ENV['DEBUG']) &&
            strtolower($_ENV['DEBUG']) == 'false' &&
            isset($_ENV['JAWSDB_URL'])
        ) {
            $connection_string = $_ENV['JAWSDB_URL'];
            $username = $_ENV['JAWSDB_USERNAME'];
            $password = $_ENV['JAWSDB_PASSWORD'];

            $p = parse_url($connection_string);
            $scheme = $p['scheme'];
            $host = $p['host'];
            $dbname = trim($p['path'], '/');
            $link = new PDO(
                "{$scheme}:host={$host};dbname={$dbname}",
                $username,
                $password
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
