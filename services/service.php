<?php
function dd($str){
    echo "<pre>";
    print_r($str);
    echo "</pre>";
    die;
}

function response($data,$code = 200){
    header_remove();
    header("Content-Type: application/json");
    header('Status: ' . $code);
    http_response_code($code);
    echo json_encode($data);
}