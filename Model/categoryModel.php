<?php

require_once("Connection/connection.php");

class Category{
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
class categoryDAO {
    private $DB;
    public function __construct() {
        $this->DB = Database::getInstance()->getConnection();
    }
    public function getCategories(){
        $stmt = $this->DB->prepare("SELECT * FROM category");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach($resultData as $row){
            $results[] = new Category($row["id"], $row["cat_name"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        return $results;
    }
    public function getCategory_by_id($ref){
        $stmt = $this->DB->prepare("SELECT * FROM category WHERE id=:ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultData as $row){
            $result = new Category($row["id"], $row["cat_name"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
    }
    public function get_lastEdited_categories(){
        $stmt = $this->DB->prepare("SELECT * FROM category ORDER BY edit_date DESC");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = array();
        foreach($resultData as $row){
            $results[] = new Category($row["id"], $row["cat_name"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        return $results;
    }

    public function getCategory_by_name($name){
        $stmt = $this->DB->prepare("SELECT * FROM category WHERE cat_name= :_name");
        $stmt->bindParam(":_name", $name, PDO::PARAM_STR);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultData as $row){
            $result = new Category($row["id"], $row["cat_name"], $row["descreption"], $row["creation_date"], $row["edit_date"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
    }
    public function addCategory(Category $category){
        $stmt = $this->DB->prepare("INSERT INTO category (cat_name, descreption)
                                    VALUE (:_name, :descrip);");
        $CN = $category->getName();
        $D = $category->getDescription();
        $stmt->bindParam(":_name", $CN, PDO::PARAM_STR);
        $stmt->bindParam(":descrip", $D, PDO::PARAM_STR);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateCategory(Category $category){
        $stmt = $this->DB->prepare("UPDATE category SET cat_name = :new_name , descreption = :new_desc , edit_date = CURRENT_TIMESTAMP WHERE id = :ref");
        $newN = $category->getName();
        $newD = $category->getDescription();
        $ref = $category->getId();
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
    public function deleteCategory($ref){
        $stmt = $this->DB->prepare("DELETE FROM category WHERE id = :ref");
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    
}

// $obj = new categoryDAO();
// $category = $obj->getCategories();

// echo'<table>
// <thead>
//     <tr>NAME</tr>
//     <tr>DESC</tr>
//     <tr>C_DATE</tr>
//     <tr>E_DATE</tr>
// </thead>
// <tbody>';
// // foreach($categories as $C){
//     echo '<tr>
//     <td>'.$C->getName().'</td>
//     <td>'.$C->getDescription().'</td>
//     <td>'.$C->getCreation_date().'</td>
//     <td>'.$C->getEdit_date().'</td>
//     </tr>';
// // }

// echo '</tbody>
// </table>';

// $category = new Category(0, 'Category4', 'Description for Category4', 0,0);
// $addcat = new categoryDAO();
// if($addcat->addCategory($category)) {
//     echo "category added seccessfully";
// }else{
//     echo "this category can not be added";
// }

// $category = new Category(4, 'Category n4', 'Description for Category n4', 0,0);
// $editcat = new categoryDAO();
// if($editcat->updateCategory($category)) {
//     echo "category edited seccessfully";
// }else{
//     echo "this category can not be edited";
// }

// $category = new Category(4, 'Category n4', 'Description for Category n4', 0,0);
// $deletecat = new categoryDAO();
// if($deletecat->deleteCategory($category->getId())) {
//     echo "category deleted seccessfully";
// }else{
//     echo "this category can not be deleted";
// }

?>