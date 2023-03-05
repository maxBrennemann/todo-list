<?php

require_once("ToDo.php");

class TaskList {

    public static function addToDo(int $listId, String $title, String $content) {
        $query = "INSERT INTO `todos` (`listId`, `title`, `description`) VALUES (:listId, :title, :content)";
        $id = DBAccess::insertQuery($query, ["listId" => $listId, "title" => $title, "content" => $content]);
        return $id;
    }

    public static function get(int $listId) {
        $query = "SELECT `id`, `title`, `description`, `state` FROM `todos` WHERE `listId` = :listId AND (`state` = 'active' OR `state` = 'done');";
        $results = DBAccess::selectQuery($query, ["listId" => $listId]);
        return $results;
    }

    public static function getListInfo(int $listId) {
        $query = "SELECT `title` FROM lists WHERE id = :listId";
        $result = DBAccess::selectQuery($query, ["listId" => $listId]);
        if ($result != null) {
            return $result[0]["title"];
        }
        return $result;
    }

    public static function editListTitle(int $listId, String $listTitle) {
        $query = "UPDATE `lists` SET `title` = :title WHERE `id` = :id;";
        DBAccess::updateQuery($query, [
            "title" => $listTitle,
            "id" => $listId,
        ]);
    }

    public static function editTitle(int $listItemId, String $title) {
        $query = "UPDATE `todos` SET `title` = :title WHERE `id` = :listItemId;";
        DBAccess::updateQuery($query, ["listItemId" => $listItemId, "title" => $title]);
    }

    public static function editDescription(int $listItemId, String $description) {
        $query = "UPDATE `todos` SET `description` = :description WHERE `id` = :listItemId;";
        DBAccess::updateQuery($query, ["listItemId" => $listItemId, "description" => $description]);
    }

    public static function removeToDo(int $listItemId) {
        $query = "DELETE FROM `todos` WHERE `id` = :listItemId;";
        DBAccess::deleteQuery($query, ["listItemId" => $listItemId]);
        return "success";
    }

    public static function updateStatus(int $listItemId, String $status) {
        $query= "UPDATE `todos` SET `state` = :status WHERE `id` = :id;";
        DBAccess::updateQuery($query, [
            "status" => $status,
            "id" => $listItemId,
        ]);
    }

}

?>