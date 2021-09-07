<?php

use function PHPSTORM_META\type;

class Cart {
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

    function show($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $P = new Products($vars['db']);
            $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];

            foreach ($cart as &$item) {
                $product = $P->get($item['id'])[0];
                $item['name'] = $product['name'];
                $item['price'] = $product['price'];
                $item['description'] = $product['description'];
                $item['picture'] = $product['picture'];
                $item['totalPrice'] = $item['numOrder'] * $item['price'];
            }

            $vars['cart'] = $cart;

            $this->wrap('/views/cart/cart_show.php', 'Cart', $vars);
        }
    }

    function update($vars, $httpmethod) {
        if ($httpmethod == 'POST') {
            $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
            $ids = $_POST['ids'];
            $numOrders = $_POST['numOrders'];

            foreach ($ids as $k => $id) {
                $numOrder = $numOrders[$k];

                foreach ($cart as $k => &$item) {
                    if ($id == $item['id']) {
                        if ($numOrder == 0) {
                            unset($cart[$k]);
                        } else {
                            $item['numOrder'] = $numOrder;
                        }
                    }
                }
            }
            $_SESSION['cart'] = $cart;

            header('Content: application/json');
            echo json_encode($cart);
        }
    }


    function add($vars, $httpmethod) {
        // unset($_SESSION['cart']);

        if ($httpmethod == 'POST') {
            $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];

            $duplicate = false;
            foreach ($cart as &$item) {
                if ($_POST['id'] == $item['id']) {
                    $item['numOrder'] += $_POST['numOrder'];
                    $duplicate = true;
                    break;
                }
            }
            if (!$duplicate) {
                $cart[] = [
                    "id" => $_POST['id'],
                    "numOrder" => $_POST['numOrder']
                ];
            }

            $_SESSION['cart'] = $cart;
        }

        header('Content: application/json');
        echo json_encode($cart);
    }

    function get($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $cart = (isset($_SESSION['cart'])) ? $_SESSION['cart'] : [];
            $P = new Products($vars['db']);

            $cart_details = [];
            foreach ($cart as $item) {
                $product = $P->get($item['id'])[0];

                $cart_details[] = [
                    "id" => $item['id'],
                    "numOrder" => $item['numOrder'],
                    "name" => $product['name'],
                    "price" => $product['price'],
                    "picture" => $product['picture'],
                    "description" => $product['description'],
                ];
            }

            header('Content: application/json');
            echo json_encode($cart_details);
        }
    }

    function remove($vars, $httpmethod) {
        if ($httpmethod == 'POST') {
            $cart = &$_SESSION['cart'];

            foreach ($cart as $k => $v) {
                if ($v['id'] == $vars['id']) {
                    unset($cart[$k]);
                }
            }
        }
    }


    function clear($vars, $httpmethod) {
        unset($_SESSION['cart']);
    }
}
