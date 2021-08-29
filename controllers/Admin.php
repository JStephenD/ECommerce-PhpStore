<?php

class Admin {

    function wrap($include_file, $title, $categories = null) {
        Utils::admin_login_required();

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
            $this->wrap('/views/admin/admin_products.php', 'ADMIN - PRODUCTS', $categories = $categories);
        } else {
            $file = $_FILES['picture'];

            $fname = $file['name'];
            $ftype = $file['type'];
            $ftmpName = $file['tmp_name'];
            $fsize = $file['size'];
            $ferror = $file['error'];

            $fext = explode('.', $fname);
            $fextActual = strtolower(end($fext));

            $imgFileName = uniqid('', true) . "." . $fextActual;
            $fdest = 'uploads/product_picture/' . $imgFileName;

            move_uploaded_file($ftmpName, $fdest);

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
