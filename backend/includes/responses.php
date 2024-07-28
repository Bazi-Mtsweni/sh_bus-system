<?php

function response($bool, $msg)
{
    header('Content-Type: application/json');
    echo json_encode(array('success' => $bool, 'error' => $msg));
    exit;
}
function redirect($bool, $path)
{
    header('Content-Type: application/json');
    echo json_encode(array('success' => $bool, 'redirect' => $path));
    exit;
}

?>