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
}
