<?php

require_once("TaskList.php");

class ListManager {

    private $id;
    private $idUser;

    function __construct(int $idUser) {
        $this->idUser = $idUser;
    }

    public function getAllListTitles() {
        $query = "SELECT `title` FROM `lists` WHERE `userId` = :userId";
        return DBAccess::selectQuery($query, ["userId" => $this->idUser]);
    }

    public function addNewList(String $title, String $description) {
        $query = "INSERT INTO lists (`title`, `description`) VALUES (:title, :desc);";
        $listId = DBAccess::insertQuery($query, ["title" => $title, "desc" => $description]);
        return $listId;
    }

    public function deleteList(int $listId) {
        $query = "DELETE FROM lists WHERE id = :id";
        DBAccess::deleteQuery($query, ["id" => $listId]);
    }

    public function addUserToList(int $initiatorUserId, int $userId) {
        if ($initiatorUserId == $this->idUser) {
            $query = "INSERT INTO list_to_user (idList, idAdditionalUser) VALUES (:idList, :idUser)";
            DBAccess::insertQuery($query, ["idList" => $this->id, "idUser" => $userId]);
        }
    }

}

?>