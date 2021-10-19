<?php

class Utils {

    static function login_required($redirect_url = '/login') {
    }

    static function admin_login_required($redirect_url = '/admin/login') {
        if (!isset($_SESSION['admin'])) {
            header("Location: $redirect_url");
        }
    }

    static function save_image($upload_location = 'uploads/', $files_name = 'picture') {
        $file = $_FILES[$files_name];

        $fname = $file['name'];
        $ftype = $file['type'];
        $ftmpName = $file['tmp_name'];
        $fsize = $file['size'];
        $ferror = $file['error'];

        $fext = explode('.', $fname);
        $fextActual = strtolower(end($fext));

        $imgFileName = uniqid('', true) . "." . $fextActual;
        $fdest = $upload_location . $imgFileName;

        move_uploaded_file($ftmpName, $fdest);

        return $imgFileName;
    }

    static function pprint($data) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    static function routes() {
        return [
            [['GET', 'POST'], '/', ['Store', 'index']],
            [['GET', 'POST'], '/about', ['Store', 'about']],
            [['GET', 'POST'], '/product', ['Store', 'product']],
            [['GET', 'POST'], '/product/details/{id}', ['Store', 'product_details']],
            [['GET', 'POST'], '/shopping-cart', ['Store', 'shopping_cart']],
            [['GET', 'POST'], '/blog', ['Store', 'blog']],
            [['GET', 'POST'], '/contact', ['Store', 'contact']],

            [['GET', 'POST'], '/cart/add', ['Cart', 'add']],
            [['GET', 'POST'], '/cart/get', ['Cart', 'get']],
            [['GET', 'POST'], '/cart/clear', ['Cart', 'clear']],
            [['GET', 'POST'], '/cart', ['Cart', 'show']],
            [['GET', 'POST'], '/cart/update', ['Cart', 'update']],
            [['GET', 'POST'], '/cart/remove/{id}', ['Cart', 'remove']],
            [['GET', 'POST'], '/cart/checkout', ['Cart', 'checkout']],

            [['GET', 'POST'], '/customer', ['Customer', 'index']],
            [['GET', 'POST'], '/customer/login', ['Customer', 'login']],
            [['GET', 'POST'], '/customer/register', ['Customer', 'register']],
            [['GET', 'POST'], '/customer/logout', ['Customer', 'logout']],

            [['GET', 'POST'], '/admin', ['Admin', 'index']],
            [['GET', 'POST'], '/admin/login', ['Admin', 'login']],
            [['GET', 'POST'], '/admin/logout', ['Admin', 'logout']],

            [['GET', 'POST'], '/admin/categories', ['Admin', 'categories']],

            [['GET', 'POST'], '/admin/products/add', ['Admin', 'products_add']],
            [['GET', 'POST'], '/admin/products/list', ['Admin', 'products_list']],
            [['GET', 'POST'], '/admin/products/list/{id}', ['Admin', 'products_id']],
            [['GET', 'POST'], '/admin/products/update/{id}', ['Admin', 'products_update']],
            [['GET', 'POST'], '/admin/products/delete/{id}', ['Admin', 'products_delete']],
        ];
    }
}
