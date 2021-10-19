<?php

function loadClasses($class) {
    $dirs = [
        __DIR__ . '/controllers/', $_SERVER['DOCUMENT_ROOT'] . '/controllers/',

        __DIR__ . '/models/', $_SERVER['DOCUMENT_ROOT'] . '/models/',

        __DIR__ . '/classes/', $_SERVER['DOCUMENT_ROOT'] . '/classes/',
    ];

    foreach ($dirs as $dir) {
        if (file_exists($dir . $class . '.php')) {
            require_once $dir . $class . '.php';
        }
        if (file_exists($dir . strtolower($class) . '.php')) {
            require_once $dir . strtolower($class) . '.php';
        }
    }
}


spl_autoload_register('loadClasses');
