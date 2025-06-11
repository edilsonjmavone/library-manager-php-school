<?php
define(
    'BASE_URL',
    '/phpmodule/library-manager-php'
    // dirname($_SERVER['SCRIPT_NAME'])
);

function redirect($path)
{
    header("Location: " . BASE_URL . $path);
    exit();

}