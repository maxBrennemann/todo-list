<?php

require_once("TaskList.php");

class ListManager {

    private $id;
    private $idUser;

    function __construct(int $idUser) {
        $this->idUser = $idUser;
    }

    public function getAllListTitles() {
        $query = "SELECT `id`, `title` FROM `lists` WHERE `userId` = :userId";
        return DBAccess::selectQuery($query, ["userId" => $this->idUser]);
    }

    public static function addNewList(int $idUser, String $title) {
        $query = "INSERT INTO lists (`userId`, `title`) VALUES (:userId, :title);";
        $listId = DBAccess::insertQuery($query, ["userId" => $idUser, "title" => $title]);
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