<?php

class Admin {

    function wrap($include_file, $title, $variables = []) {
        Utils::admin_login_required();

        foreach ($variables as $k => $v) {
            $$k = $v;
        }

        echo `<!DOCTYPE html><html>`;

        $_SESSION['TITLE'] = $title;
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/head.php');

        echo `<body class="hold-transition skin-blue sidebar-mini">`;

        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/header.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/main-sidebar.php');

        require_once($_SERVER['DOCUMENT_ROOT'] . $include_file);

        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/footer.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/control-sidebar.php');
        require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/scripts.php');

        echo `</body></html>`;
    }

    function index($vars, $httpmethod) {
        $this->wrap('/views/admin/admin_index.php', 'ADMIN');
    }

    function categories($vars, $httpmethod) {
        if ($httpmethod == "GET") {
            $this->wrap('/views/admin/admin_categories.php', 'ADMIN - CATEGORIES');
        } else {
            $data = array(
                "name" => $_POST['name']
            );
            $categories = new Categories($vars['db']);
            $categories->add($data);

            sleep(.5);
        }
    }

    function products($vars, $httpmethod) {
        if ($httpmethod == "GET") {
            $category = new Categories($vars['db']);
            $categories = $category->get();
            $this->wrap('/views/admin/admin_products.php', 'ADMIN - PRODUCTS', ['categories' => $categories]);
        } else {
            $imgFileName = Utils::save_image('uploads/product_picture/', 'picture');

            $data = array(
                "name" => $_POST['name'],
                "description" => $_POST['description'],
                "price" => $_POST['price'],
                "picture" => $imgFileName,
                "category_id" => $_POST['category_id']
            );
            $product = new Products($vars['db']);
            $product->add($data);

            sleep(.5);
        }
    }

    function products_list($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $P = new Products($vars['db']);
            $products = $P->get();
            $this->wrap('/views/admin/admin_products_list.php', 'ADMIN - PRODUCTS LISTING', ['products' => $products]);
        } else {
        }
    }

    function products_id($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $id = $vars['id'];
            $P = new Products($vars['db']);
            $product = $P->get($id)[0];
            $this->wrap('/views/admin/admin_products_listitem.php', 'ADMIN - PRODUCT ITEM', ['product' => $product]);
        } else {
        }
    }

    function products_update($vars, $httpmethod) {
        if ($httpmethod == 'GET') {
            $id = $vars['id'];
            $P = new Products($vars['db']);
            $C = new Categories($vars['db']);
            $product = $P->get($id)[0];
            $categories = $C->get();
            $this->wrap('/views/admin/admin_products_update.php', 'ADMIN - UPDATE PRODUCT', [
                'product' => $product,
                'categories' => $categories
            ]);
        } else {
            $data = array(
                "id" => $_POST['id'],
                "name" => $_POST['name'],
                "price" => $_POST['price'],
                "description" => $_POST['description'],
                "category_id" => $_POST['category_id'],
            );

            if ($_POST['imageChanged'] == 'true') {
                $data['picture'] = Utils::save_image('uploads/product_picture/', 'picture');
            } else {
                $data['picture'] = $_POST['original_picture'];
            }

            $P = new Products($vars['db']);
            $result = $P->update($data);
            sleep(.5);

            header('Content-Type: application/json');
            echo json_encode($data);
        }
    }

    function login($vars, $httpmethod) {
        if ($httpmethod == "GET") {
            echo `<!DOCTYPE html><html>`;

            $_SESSION['TITLE'] = "ADMIN - LOGIN";
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/head.php');

            echo `<body class="hold-transition skin-blue sidebar-mini">`;

            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/header.php');

            require_once($_SERVER['DOCUMENT_ROOT'] . '/views/admin/admin_login.php');


            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/footer.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/control-sidebar.php');
            require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/admin/scripts.php');

            echo `</body></html>`;
        } else {
            $data = array(
                "username" => $_POST['username'],
                "password" => hash('sha256', $_POST['password'])
            );
            $user = new Admins($vars['db']);
            $result = $user->login($data);

            if ($result == "incorrectPassword") {
                header("Location: /admin/login");
            } else {
                $_SESSION['admin'] = $result;
                header("Location: /admin");
            }
        }
    }

    function logout($vars, $httpmethod) {
        session_unset();
        session_destroy();
        Header("Location: /admin/login");
    }
}