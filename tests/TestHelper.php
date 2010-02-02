<?php

function testAutoloader($className)
{
    $file = str_replace('_', '/', $className) . '.php';
    return include $file;
}

$libDir = dirname(__FILE__) . '/../library';
if (file_exists($libDir) && is_dir($libDir)) {
    set_include_path($libDir . PATH_SEPARATOR . get_include_path());
}
spl_autoload_register('testAutoloader');
unset($libDir);
