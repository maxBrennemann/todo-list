<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = getParameter("r", null);

    switch ($request) {
        case "":
            break;
        case "":
            break;
        default:
            echo "no request was fired";
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {

}

function getParameter($param, $default = null, $type = "POST") {
    $value = $default;

    if ($type == "POST") {
        if (isset($_POST[$param])) {
            $value = $_POST[$param];
        }
    } else if ($type == "GET") {
        if (isset($_GET[$param])) {
            $value = $_GET[$param];
        }
    }

    return $value;
}

?>