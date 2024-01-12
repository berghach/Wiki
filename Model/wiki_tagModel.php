<?php

require_once("Connection/connection.php");

class WikiTag {
    private $wiki;
    private $tag;
    public function __construct($wiki, $tag) {
        $this->wiki = $wiki;
        $this->tag = $tag;
    }
    public function get_wiki(){
        return $this->wiki;
    }
    public function get_tag() {
        return $this->tag;
    }
}

class wikitagDAO{
    private $DB;
    public function __construct() {
        $this->DB = Database::getInstance()->getConnection();
    }
    public function insert_tag(WikiTag $obj) {
        $stmt = $this->DB->prepare("INSERT INTO wiki_tag (wiki_id, tag_id) 
                                    VALUES (:wiki, :tag)");
        $W = $obj->get_wiki();
        $T = $obj->get_tag();
        $stmt->bindParam(":wiki", $W, PDO::PARAM_INT);
        $stmt->bindParam(":tag", $T, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
}

?>