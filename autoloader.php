<?php
spl_autoload_register('custom_autoloader');

/**
 * Charge automatiquement nos classes
 * @param $className
 */
function custom_autoloader($className)
{
    $path      = ABSOLUTE_PATH .'/model/';
    $filename  = $path .$className . '.php';
    if (file_exists($filename)) {
        require_once $filename;
    }
}