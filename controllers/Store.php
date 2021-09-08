<?php

class Store {

    function wrap($include_file, $title = 'Home', $variables = []) {

        foreach ($variables as $k => $v) {
            $$k = $v;
        }

        echo `<!DOCTYPE html><html lang="en">`;

        $_SESSION['TITLE'] = $title;
        require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/head.php");

        echo `<body class="animsition">`;

        if ($title == "Home") {
            require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/header.php");
        } else {
            require_once($_SERVER['DOCUMENT_ROOT'] . "/includes/store/header2.php");
        }

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
            $P = new Products($vars['db']);
            $vars['products'] = $P->get();
            $vars['tags'] = $P->get_tags();
            $this->wrap('/views/store/store_index.php', 'Home', $vars);
        }
    }

    function about($vars, $httpmethod) {
        $this->wrap('/views/store/store_about.php', 'About Store', $vars);
    }

    function product($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $P = new Products($vars['db']);
            $vars['products'] = $P->get();
            $vars['tags'] = $P->get_tags();
            $this->wrap('/views/store/store_product.php', 'Products', $vars);
        }
    }

    function product_details($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $P = new Products($vars['db']);
            $vars['products'] = $P->get();
            $vars['product'] = $P->get($vars['id']);
            $vars['tags'] = $P->get_tags();
            $this->wrap('/views/store/store_product_detail.php', 'Products - Detail', $vars);
        } else {
            $P = new Products($vars['db']);
            $product = $P->get($vars['id']);
            header('Content-type: application/json');
            echo json_encode($product);
        }
    }

    function shopping_cart($vars, $httpmethod) {
        $this->wrap('/views/store/store_shopping_cart.php', 'Your Cart', $vars);
    }

    function blog($vars, $httpmethod) {
        $this->wrap('/views/store/store_blog.php', 'Blog', $vars);
    }

    function contact($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $this->wrap('/views/store/store_contact.php', 'Contact Us!', $vars);
        } else {
            $data = array(
                "email" => $_POST['email'],
                "message" => $_POST['message']
            );
            $contact = new Contact($vars['db']);
            $result = $contact->add($data);

            sleep(.5);
        }
    }
}
