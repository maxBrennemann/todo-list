<?php

require_once("ToDo.php");

class TaskList {

    public static function addToDo(int $listId, String $title, String $content) {
        $query = "INSERT INTO `todos` (`listId`, `title`, `description`) VALUES (:listId, :title, :content)";
        $id = DBAccess::insertQuery($query, ["listId" => $listId, "title" => $title, "content" => $content]);
        return $id;
    }

    public static function get(int $listId) {
        $query = "SELECT `id`, `title`, `description` FROM `todos` WHERE `listId` = :listId AND `state` = 'active';";
        $results = DBAccess::selectQuery($query, ["listId" => $listId]);
        return $results;
    }

    public static function editTitle(int $listItemId, String $title) {
        $query = "UPDATE `todos` SET `title` = :title WHERE `id` = :listItemId;";
        DBAccess::updateQuery($query, ["listItemId" => $listItemId, "title" => $title]);
    }

    public static function editDescription(int $listItemId, String $description) {
        $query = "UPDATE `todos` SET `description` = :description WHERE `id` = :listItemId;";
        DBAccess::updateQuery($query, ["listItemId" => $listItemId, "description" => $description]);
    }

    function removeToDo() {

    }

    function markAsDone() {

    }

}

?>