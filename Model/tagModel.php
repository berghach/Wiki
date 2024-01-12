<?php

require_once("Connection/connection.php");

class Tag{
    private $id;
    private $Name;
    private $Description;
    private $Creation_date;
    private $Edit_date;
    public function __construct($id, $Name, $Description, $Creation_date, $Edit_date){
        $this->id = $id;
        $this->Name = $Name;
        $this->Description = $Description;
        $this->Creation_date = $Creation_date;
        $this->Edit_date = $Edit_date;
    }
    public function getId(){
        return $this->id;
    }
    public function getName(){
        return $this->Name;
    }
    public function getDescription(){
        return $this->Description;
    }
    public function getCreation_date(){
        return $this->Creation_date;
    }
    public function getEdit_date(){
        return $this->Edit_date;
    }
}
class tagDAO{
    private $DB;
    public function __construct() {
        $this->DB = Database::getInstance()->getConnection();
    }
    public function getTags(){
        $stmt = $this->DB->prepare("SELECT * FROM tag");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach($resultData as $row){
            $results[] = new Tag($row["id"], $row["name_tag"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        return $results;
    }
    public function getTag_by_id($ref){
        $stmt = $this->DB->prepare("SELECT * FROM tag WHERE id=:ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultData as $row){
            $result = new Tag($row["id"], $row["name_tag"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
    }
    public function get_lastEdited_Tags(){
        $stmt = $this->DB->prepare("SELECT * FROM tag ORDER BY edit_date DESC");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach($resultData as $row){
            $results[] = new Tag($row["id"], $row["name_tag"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        return $results;
    }
    public function getTag_by_name($name){
        $stmt = $this->DB->prepare("SELECT * FROM tag WHERE name_tag= :_name");
        $stmt->bindParam(":_name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultData as $row){
            $result = new Tag($row["id"], $row["name_tag"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
    }
    public function get_wikiTag($wiki){
        $stmt = $this->DB->prepare("SELECT tag.* FROM tag LEFT JOIN 
                                    (wiki LEFT JOIN wiki_tag on wiki.id=wiki_tag.wiki_id) 
                                    on tag.id=wiki_tag.tag_id WHERE wiki.id= :ref;");
        $stmt->bindParam(":ref", $wiki, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach($resultData as $row){
            $results[] = new Tag($row["id"], $row["name_tag"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        return $results;
    }
    public function addTag(Tag $tag){
        $stmt = $this->DB->prepare("INSERT INTO tag (name_tag, descreption)
                                    VALUE (:_name, :descrip);");
        $CN = $tag->getName();
        $D = $tag->getDescription();
        $stmt->bindParam(":_name", $CN, PDO::PARAM_STR);
        $stmt->bindParam(":descrip", $D, PDO::PARAM_STR);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateTag(Tag $tag){
        $stmt = $this->DB->prepare("UPDATE tag SET name_tag = :new_name , descreption = :new_desc , edit_date = CURRENT_TIMESTAMP WHERE id = :ref");
        $newN = $tag->getName();
        $newD = $tag->getDescription();
        $ref = $tag->getId();
        $stmt->bindParam(":new_name", $newN, PDO::PARAM_STR);
        $stmt->bindParam(":new_desc", $newD, PDO::PARAM_STR);
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowcount()!=0){
            return true;
        }else{
            return false;
        }

    }
    public function deleteTag($ref){
        $stmt = $this->DB->prepare("DELETE FROM tag WHERE id = :ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
}

?>