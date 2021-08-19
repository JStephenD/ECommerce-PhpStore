<?php
class Store {
    function index($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_index.php');
    }

    function about($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_about.php');
    }

    function product($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_product.php');
    }

    function shopping_cart($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_shopping_cart.php');
    }

    function blog($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_blog.php');
    }

    function contact($vars, $httpmethod) {
        require_once($_SERVER['DOCUMENT_ROOT'] . '/views/store_contact.php');
    }
}
