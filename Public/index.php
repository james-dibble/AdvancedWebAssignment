<?php
    ini_set('display_errors','0');
    include_once '..\Application\Bootstrap.php';
    Library\Routing\Router::Dispatch();
?>