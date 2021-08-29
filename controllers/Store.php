<?php

class Store {

    function wrap($include_file, $title = 'Home') {
        echo `<!DOCTYPE html>
        <html lang="en">`;

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
        $this->wrap('/views/store/store_index.php', 'Home');
    }

    function about($vars, $httpmethod) {
        $this->wrap('/views/store/store_about.php', 'About Store');
    }

    function product($vars, $httpmethod) {
        $this->wrap('/views/store/store_product.php', 'Products');
    }

    function shopping_cart($vars, $httpmethod) {
        $this->wrap('/views/store/store_shopping_cart.php', 'Your Cart');
    }

    function blog($vars, $httpmethod) {
        $this->wrap('/views/store/store_blog.php', 'Blog');
    }

    function contact($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $this->wrap('/views/store/store_contact.php', 'Contact Us!');
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
