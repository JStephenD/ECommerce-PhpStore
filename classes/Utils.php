<?php

class Utils {

    static function login_required($redirect_url = '/login') {
    }

    static function admin_login_required($redirect_url = '/admin/login') {
        if (!isset($_SESSION['admin'])) {
            header("Location: $redirect_url");
        }
    }
}
