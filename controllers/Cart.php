<?php

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
                $product = $P->get($item['id']);
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
                $product = $P->get($item['id']);

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

    function checkout($vars, $httpmethod) {
        if ($httpmethod == 'POST') {
            header('Content: application/json');

            if (!isset($_SESSION['customer'])) {
                echo json_encode(["result" => "Not logged in"]);
            } else if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo json_encode(["result" => "Cart is empty"]);
            } else if (empty($_POST['address'])) {
                echo json_encode(["result" => "Address is empty"]);
            } else if (empty($_POST['phone'])) {
                echo json_encode(["result" => "Phone is empty"]);
            } else {
                $cart = $_SESSION['cart'];
                $P = new Products($vars['db']);
                $O = new Orders($vars['db']);
                $OD = new OrderDetails($vars['db']);


                $cart_details = [];
                $total = 0.0;
                foreach ($cart as $item) {
                    $product = $P->get($item['id']);

                    $cart_details[] = [
                        "product_id" => $item['id'],
                        "numOrder" => $item['numOrder'],
                    ];
                    $total += intval($item['numOrder']) * floatval($product['price']);
                }

                $order_data = [
                    "customer_id" => intval($_SESSION['customer']['id']),
                    "address" => $_POST['address'],
                    "phone" => $_POST['phone'],
                    "total" => $total
                ];

                $order_id = $O->add($order_data);

                foreach ($cart_details as $item) {
                    $order_detail_data = [
                        "order_id" => $order_id,
                        "product_id" => $item['product_id'],
                        "quantity" => $item['numOrder']
                    ];

                    $order_detail_result = $OD->add($order_detail_data);
                }

                $_SESSION['cart'] = [];
                echo json_encode(["result" => "success"]);
            }
        }
    }


    function clear($vars, $httpmethod) {
        unset($_SESSION['cart']);
    }
}
