<?php

class ToDo {

    private $id;

    private $title;
    private $description;

    function __construct(int $id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescrpiption() {
        return $this->description;
    }

    public function edit(String $title, String $description) {
        $this->$title = $title;
        $this->description = $description;

        $query = "UPDATE `todos` SET `title` = :title SET `description`= :desc WHERE id = :id";
        $params = [
            "title" => $this->title,
            "description" => $this->description,
            "id" => $this->id,
        ];
        DBAccess::updateQuery($query, $params);
    }

    public function attachFile() {

    }

}

?>