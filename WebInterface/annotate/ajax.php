<?php
    header("Content-Type: application/json; charset=UTF-8");
    $v = json_decode(stripslashes(file_get_contents("php://input")));
    print_r($v);

?>