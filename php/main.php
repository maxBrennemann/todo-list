<?php

require_once("DBAccess.php");
require_once("classes/ListManager.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $request = getParameter("r", null);

    switch ($request) {
        case "createList":
            break;
        case "deleteList":
            break;
        case "addToDo":
            break;
        case "deleteToDo":
            break;
        case "editToDo":
            break;
        case "attachFile":
            break;
        case "changeStatus":
            break;
        default:
            echo "no request was fired";
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $request = getParameter("r", null, "GET");

    switch ($request) {
        case "createList":
            break;
        case "deleteList":
            break;
        case "addToDo":
            break;
        case "deleteToDo":
            break;
        case "editToDo":
            break;
        case "attachFile":
            break;
        case "changeStatus":
            break;
        default:
            echo "no request was fired";
    }
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