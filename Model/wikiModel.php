<?php

require_once("Connection/connection.php");

class Wiki {
    private $Id;
    private $Title;
    private $Content;
    private $Archived;
    private $Author;
    private $Creation_date;
    private $Edit_date;
    private $Category;
    public function __construct($Id, $Title, $Content, $Archived, $Author, $Creation_date, $Edit_date, $Category) {
        $this->Id = $Id;
        $this->Title = $Title;
        $this->Content = $Content;
        $this->Archived = $Archived;
        $this->Author = $Author;
        $this->Creation_date = $Creation_date;
        $this->Edit_date = $Edit_date;
        $this->Category = $Category;
    }
    public function getID() {
        return $this->Id;
    }
    public function getTitle() {
        return $this->Title;
    }
    public function getContent() {
        return $this->Content;
    }
    public function getArchived() {
        return $this->Archived;
    }
    public function getAuthor() {
        return $this->Author;
    }
    public function getCreationDate() {
        return $this->Creation_date;
    }
    public function getEditDate() {
        return $this->Edit_date;
    }
    public function getCategory() {
        return $this->Category;
    }
}

class wikiDAO {
    private $DB;
    public function __construct() {
        $this->DB = Database::getInstance()->getConnection();
    }
    public function get_allWikies() {
        $stmt = $this->DB->prepare("SELECT * FROM wiki");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function get_activeWikies(){
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE archived = 0");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function get_archivedWikies(){
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE archived = 1");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function getWikies_byId($ref) {
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE id = :ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultData as $row) {
            $result = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $result;
    }
    public function get_lastEdited_wikies() {
        $stmt = $this->DB->prepare("SELECT * FROM wiki ORDER BY edit_date DESC");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function getWiki_by_title($title){
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE title = :title");
        $stmt->bindParam(":title", $title, PDO::PARAM_STR);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultData as $row) {
            $result = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
    }
    public function getWiki_by_author($author){
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE author_id = :author");
        $stmt->bindParam(":author", $author, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function getWiki_by_category($category){
        $stmt = $this->DB->prepare("SELECT * FROM wiki WHERE wiki_category = :ref");
        $stmt->bindParam(":ref", $category, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function getWiki_by_tag($tag){
        $stmt = $this->DB->prepare("SELECT wiki.* FROM wiki LEFT JOIN 
                                    (tag LEFT JOIN wiki_tag on tag.id=wiki_tag.tag_id) 
                                    on wiki.id=wiki_tag.wiki_id WHERE tag.id=:ref");
        $stmt->bindParam(":ref", $tag, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach ($resultData as $row) {
            $results[] = new Wiki ($row["id"], $row["title"], $row["content"], $row["archived"], $row["author_id"], $row["creation_date"], $row["edit_date"], $row["wiki_category"]);
        }
        return $results;
    }
    public function archiveWiki($ref){
        $stmt = $this->DB->prepare("UPDATE wiki SET archived = 1 WHERE id = :ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowcount()!=0){
            return true;
        }else{
            return false;
        }
    }
    public function addWiki(Wiki $wiki){
        $stmt = $this->DB->prepare("INSERT INTO wiki (title, content, author_id, edit_date, wiki_category)
                                    VALUE (:title, :content, :author, CURRENT_TIMESTAMP, :catgory);");
        $T = $wiki->getTitle();
        $C = $wiki->getContent();
        $Au = $wiki->getAuthor();
        $Ca = $wiki->getCategory();
        $stmt->bindParam(":title", $T, PDO::PARAM_STR);
        $stmt->bindParam(":content", $C, PDO::PARAM_STR);
        $stmt->bindParam(":author", $Au, PDO::PARAM_INT);
        $stmt->bindParam(":category", $Ca, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateWiki(Wiki $wiki){
        $stmt = $this->DB->prepare("UPDATE wiki SET title = :new_title , content = :new_content , 
                                    edit_date = CURRENT_TIMESTAMP , wiki_category = :new_category WHERE id = :ref");
        $newT = $wiki->getTitle();
        $newC = $wiki->getContent();
        $newCa = $wiki->getCategory();
        $ref = $wiki->getID();
        $stmt->bindParam(":new_title", $newT, PDO::PARAM_STR);
        $stmt->bindParam(":new_content", $newC, PDO::PARAM_STR);
        $stmt->bindParam(":new_category", $newCa, PDO::PARAM_INT);
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowcount()!=0){
            return true;
        }else{
            return false;
        }
    }
    public function deleteWiki($ref){
        $stmt = $this->DB->prepare("DELETE FROM wiki WHERE id = :ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}

//code testing
// $tag=4;
// $wiki = new wikiDAO();
// $B = $wiki->getWiki_by_tag($tag);
// foreach($B as $c){
//     echo "".$c->getID()."/".$c->getTitle()."/".$c->getContent()."/".$c->getEditDate()."";
//     echo "<br>";
// }

?>