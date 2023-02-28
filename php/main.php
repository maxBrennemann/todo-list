<?php

/* https://stackoverflow.com/questions/60254310/cors-problem-with-axios-from-a-vue-app-to-a-php-api-running-on-wamp */
function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
}
cors();

header("Access-Control-Allow-Origin: *");
session_start();

require_once("DBAccess.php");
require_once("classes/ListManager.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    $request = $data["r"];

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
        case "login":
            $email = $data['username'];
            $password = $data['password'];
            $status = loginUser($email, $password);

            if ($status) {
                echo json_encode([
                    "status" => "success", 
                    "token" => $_SESSION["token"],
                ]);
            } else {
                echo json_encode(["status" => "false"]);
            }
            break;
        case "register":
            $email = $data['username'];
            $password = $data['password'];
            $userId = registerUser($email, $password);

            if ($userId == false) {
                echo json_encode(["status" => "false"]);
            } else {
                echo json_encode(["status" => "success", "user" => $userId]);
            }
            break;
        default:
            echo "no request was fired";
    }
} else if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $request = getParameter("r", null, "GET");

    switch ($request) {
        case "listOverview":
            $userId = getParameter("user", 0, "GET");
            $lm = new ListManager($userId);
            echo json_encode($lm->getAllListTitles());
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

function loginUser(String $email, String $password) {
    $query = "SELECT `id`, `pwHash` FROM `user` WHERE `email` = :email LIMIT 1;";
    $user = DBAccess::selectQuery($query, ["email" => $email]);

    if ($user != null) {
        $isPasswordCorrect = password_verify($password, $user[0]["pwHash"]);

        if ($isPasswordCorrect) {
            $_SESSION["userId"] = $user[0]["id"];
            $_SESSION["loggedIn"] = true;
            $_SESSION["token"] = md5(uniqid(mt_rand(), true));
            return true;
        }
    }

    return false;
}

function registerUser(String $email, String $password) {
    $query = "SELECT * FROM `user` WHERE `email` = :email";
    $data = DBAccess::selectQuery($query, ["email" => $email]);

    if ($data == null) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO `user` (`email`, `pwHash`) VALUES (:email, :pwhash);";
        $userId = DBAccess::insertQuery($query, ["email" => $email, "pwhash" => $passwordHash]);
        return $userId;
    }
        
    return false;
}

?>