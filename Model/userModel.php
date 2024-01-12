<?php

require_once("Connection/connection.php");

class User {
    private $ID;
    private $Fullname;
    private $Email;
    private $Username;
    private $Password;
    private $Userrole;
    public function __construct($ID, $Fullname,  $Username, $Email,$Password, $Userrole) {
        $this->ID = $ID;
        $this->Fullname = $Fullname;
        $this->Username = $Username;
        $this->Email = $Email;
        $this->Password = $Password;
        $this->Userrole = $Userrole;
    }
    public function getID() {
        return $this->ID;
    }
    public function getFullname() {
        return $this->Fullname;
    }
    public function getUsername() {
        return $this->Username;
    }
    public function getEmail() {
        return $this->Email;
    }
    public function getPassword() {
        return $this->Password;
    }
    public function getUserrole() {
        return $this->Userrole;
    }
}

class userDAO {
    private $DB;
    public function __construct() {
        $this->DB = Database::getInstance()->getConnection();
    }
    public function getUsers(){
        $stmt = $this->DB->query("SELECT * FROM user;");
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results=array();
        foreach($resultData as $row){
            $results[] = new User($row["id"], $row["fullname"], $row["username"], $row["e_mail"], $row["psw"], $row["user_role"]);
        }
        return $results;
    }
    public function getUser_by_username($username){
        $stmt = $this->DB->prepare("SELECT * FROM user WHERE username = :username;");
        $stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $stmt->execute();
        $resultData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($resultData as $row){
            $result = new User($row["id"], $row["fullname"], $row["username"], $row["e_mail"], $row["psw"], $row["user_role"]);
        }
        if(!empty($result)){
            return $result;
        }else{
            return null;
        }
        
    }
    public function addUser(User $User){
        $stmt = $this->DB->prepare("INSERT INTO user (fullname, username, e_mail, psw)
                                    VALUE (:fullname, :username, :e_mail, :passw);");
        $FN = $User->getFullname();
        $UN = $User->getUsername();
        $EM = $User->getEmail();
        $PW = $User->getPassword();
    
        $stmt->bindParam(":fullname", $FN, PDO::PARAM_STR);
        $stmt->bindParam(":username", $UN, PDO::PARAM_STR);
        $stmt->bindParam(":e_mail", $EM, PDO::PARAM_STR);
        $stmt->bindParam(":passw", $PW, PDO::PARAM_STR);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }
    public function updateUser(User $User){
        $stmt = $this->DB->prepare("UPDATE user SET fullname = :new_FN, username = :new_UN, e_mail = :new_email, psw = :new_psw WHERE id = :ref");
        $newFN = $User->getFullname();
        $newUN = $User->getUsername();
        $newEM = $User->getEmail();
        $newPW = $User->getPassword();
        $ref = $User->getId();
        $stmt->bindParam(":new_FN", $newFN, PDO::PARAM_STR);
        $stmt->bindParam(":new_UN", $newUN, PDO::PARAM_STR);
        $stmt->bindParam(":new_email", $newEM, PDO::PARAM_STR);
        $stmt->bindParam(":new_psw", $newPW, PDO::PARAM_STR);
        $stmt->bindParam(":ref", $ref, PDO::PARAM_INT);
        $stmt->execute();
        if($stmt->rowcount()!=0){
            return true;
        }else{
            return false;
        }
    }
}

//code testing
// $usersData = new userDAO();
// $A = 'admin1';
// $user= $usersData->getUser_by_username($A);
// if(!empty($user)){
// echo'<table>
// <thead>
//     <tr>ID</tr>
//     <tr>NAME</tr>
//     <tr>E-MAIL</tr>
//     <tr>PASSWORD</tr>
//     <tr>ROLE</tr>
// </thead>
// <tbody>';
// // foreach($user as $U){
//     echo '<tr>
//     <td>'.$user->getID().'</td>
//     <td>'.$user->getFullname().'</td>
//     <td>'.$user->getEmail().'</td>
//     <td>'.$user->getPassword().'</td>
//     <td>'.$user->getUserrole().'</td>
//     </tr>';
// // }

// echo '</tbody>
// </table>';
// }else{echo 'user not found';}

// $author = new User(0,"Author5","author5", "author5@mail.com", "author555", 0);
// $user = new userDAO();
// if($user->addUser($author)){
//     echo "user added seccessfully";
// }else{
//     echo "this user can not be added";
// }


// $psw = "jhon1234";
// $hashpsw = password_hash($psw, PASSWORD_BCRYPT);
// $author = new User(8,"Jhon Legend","jhon1", "jhon1@mail.com", $hashpsw, 0);
// $user = new userDAO();
// if($user->updateUser($author)){
//     echo "user updated seccessfully";
// }else{
//     echo "this user can not be updated";
// }
?>