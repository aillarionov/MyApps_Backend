<?php
require_once "paths.php";
require_once "config.php";

$path = $_SERVER['PATH_INFO'];
$fileName = CACHE_DIR . '/' . $path;

if (file_exists($fileName)) {
    $fileTime = filemtime($fileName);
    if ($fileTime + CACHE_LIFE > time()) {
        
        if (COMPRESSION) {
            header("Content-Encoding: gzip");
        }
        
        header("Last-Modified: " . gmdate(DT_LAST_MODIFIED, $fileTime));
        
        readfile($fileName);
        
        die;
    }
}

require_once "rest.php";