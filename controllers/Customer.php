<?php


class Customer {
    function wrap($include_file, $title, $variables = []) {
        foreach ($variables as $k => $v) {
            $$k = $v;
        }

        echo `<!DOCTYPE html><html lang="en">`;

        $_SESSION['TITLE'] = $title;
        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/head.php");

        echo `<body class="animsition">`;

        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/header2.php");

        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/cart.php");

        require_once($_SERVER['DOCUMENT_ROOT'] . $include_file);

        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/footer.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/backtotop.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/modal1.php");
        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/scripts.php");

        echo `</body></html>`;
    }

    function index($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $this->wrap('/views/customer/index.php', 'Customer Forms', $vars);
        }
    }

    function login($vars, $httpmethod) {
        if ($httpmethod == 'POST') {
            header("Content: application/json");
            $data = [
                "username" => $_POST['username'],
                "password" => hash('sha256', $_POST['password']),
            ];

            if ($data['username'] == '' || $_POST['password'] == '') {
                echo json_encode(["result" => "Invalid Entry"]);
                return;
            }

            $C = new Customers($vars['db']);
            $result = $C->login($data);


            if ($result == "incorrectPassword") {
                echo json_encode(["result" => "Incorrect Password"]);
            } else if ($result == "userNotFound") {
                echo json_encode(["result" => "User Not Found"]);
            } else {
                echo json_encode(["result" => "success"]);
                $_SESSION['customer'] = $result;
            }
        }
    }

    function register($vars, $httpmethod) {
        if ($httpmethod == 'POST') {
            header("Content: application/json");
            $data = [
                "username" => $_POST['username'],
                "password" => hash('sha256', $_POST['password']),
            ];

            if ($data['username'] == '' || $_POST['password'] == '') {
                echo json_encode(["result" => "Invalid Entry"]);
                return;
            }

            $C = new Customers($vars['db']);
            $result = $C->register($data);


            if ($result == "userExists") {
                echo json_encode(["result" => "User Exists"]);
            } else if ($result == "unsucessful") {
                echo json_encode(["result" => "Server Error"]);
            } else if ($result == "success") {
                echo json_encode(["result" => "success"]);
            }
        }
    }

    function logout($vars, $httpmethod) {
        unset($_SESSION['customer']);
        $referer = $_SERVER['HTTP_REFERER'];
        $uri = (isset($referer) && !empty($referer)) ? $referer : "/";
        Header("Location: $uri");
    }
}
