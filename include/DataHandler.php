<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataHandler
 *
 * @author Shawn
 */

class DataHandler {
    
    private $conn;
 
    function __construct() {
        require_once dirname(__FILE__) . '/DB_Connect.php';
        // opening db connection
        $db = new DB_Connect();
        $this->conn = $db->get_conn();
    }
    public function check_group_name($name){
         try {
            $sql = $this->conn->prepare("SELECT * FROM tb_group WHERE name=?");
            $sql->bindValue(1, $name );
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
        
    }

    /**
     * Checking admin login
     * @param String $username Admin login id
     * @param String $password Admin login password
     * @return boolean User login status success/fail
     * @return String the reasons of fail
     */
    public function check_login($username, $password) {
        try {
            $response = array();
            $sql = $this->conn->prepare("SELECT password,api_key FROM tb_user WHERE username=?");
            $sql->bindValue(1, $username );
            $sql->execute();
            if($row = $sql->fetch()){
                //$boolmatch = PassHash::check_password($row['password'], $password);
                $boolmatch = $row['password'] === $password;
                $response['flag'] = $boolmatch;
                if($boolmatch){
                    $response['msg'] = $row['api_key'];
                }else{
                    $response['msg'] = 'Invaild password!';
                }
            }else{
                $response['flag'] = false;
                $response['msg'] = 'Invaild username!';
            }
            return $response;
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
        
    }
    /**
     * Get all groups
     * @return Array 
     */
    public function get_group(){
        try {
            $sql = $this->conn->prepare("SELECT name,amount from tb_group");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return $result;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Add a question group
     * @return boolean status success/fail 
     */
    public function add_group($name){
        try {
//            
            $sql = $this->conn->prepare("INSERT INTO tb_group(name) VALUES(?)");
            $sql->bindValue(1, $name );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Delete a question group record
     * @return boolean status success/fail 
     */
    public function delete_group($name){
        try {
            $sql = $this->conn->prepare("DELETE FROM tb_group WHERE name=?");
            $sql->bindValue(1, $name );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Alter group name
     * @return boolean status success/fail 
     */
    public function alter_group_name($id, $name){
        try {
            $sql = $this->conn->prepare("UPDATE tb_group SET name=? WHERE id=?");
            $sql->bindValue(1, $name );
            $sql->bindValue(2, $id );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Get all questions
     * @return array/null
     */
    public function get_question(){
        try {
            $sql = $this->conn->prepare("SELECT A.id,A.context,B.name FROM tb_question A,tb_group B WHERE A.group_num=B.id");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return $result;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Getquestions by group name
     * @param String $name group name
     * @return array/null
     */
    public function get_question_by_groupname($name){
        try {
            $sql = $this->conn->prepare("SELECT A.id,A.context FROM tb_question A,tb_group B WHERE A.group_num=B.id AND B.name=?");
            $sql->bindValue(1, $name );
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return $result;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
        
    }

        /**
     * update group num of the question
     * @param int $id question item
     * @param String $groupName the group that question belong
     * @return boolean  status success/fail
     */
    public function update_question_group_num($id,$groupName){
        try {
            
            $sql0 = $this->conn->prepare("SELECT A.id FROM tb_group A,tb_question B WHERE B.group_num=A.id AND B.id=?");
            $sql0->bindValue(1, $id );
            $sql0->execute(); 
            $row0 = $sql0->fetch();
            
            $sql1 = $this->conn->prepare("SELECT id FROM tb_group WHERE name=?");
            $sql1->bindValue(1, $groupName );
            $sql1->execute(); 
            $row = $sql1->fetch();
            if(!$row0 && !$row){
                return false;
            }
            $sql = $this->conn->prepare("UPDATE tb_question SET group_num=? WHERE id=?");
            $sql->bindValue(1, $row['id'] );
            $sql->bindValue(2, $id );
            
            $sql2 = $this->conn->prepare("UPDATE tb_group SET amount = amount + 1 WHERE id=?");
            $sql2->bindValue(1, $row['id'] );
            
            $sql3 = $this->conn->prepare("UPDATE tb_group SET amount = amount - 1 WHERE id=?");
            $sql3->bindValue(1, $row0['id'] );
            
            if($sql->execute() && $sql2->execute() && $sql3->execute() ){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Add a question
     * @param String $text question item
     * @param int $groupName the group that question belong
     * @return boolean  status success/fail
     */
    public function add_question($text, $groupName){
        try {
            $sql1 = $this->conn->prepare("SELECT id FROM tb_group WHERE name=?");
            $sql1->bindValue(1, $groupName );
            $sql1->execute(); 
            $row = $sql1->fetch();
            if(!$row){
                return false;
            }
            
            //$sql = $this->conn->prepare("UPDATE tb_group SET name=? WHERE id=?");
            $sql = $this->conn->prepare("INSERT INTO tb_question(context, group_num) VALUES(?,?)");
            $sql->bindValue(1, $text );
            $sql->bindValue(2, $row['id']);
            
            $sql2 = $this->conn->prepare("UPDATE tb_group SET amount = amount + 1 WHERE id=?");
            $sql2->bindValue(1, $row['id'] );
            
            if($sql->execute() && $sql2->execute() ){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Delete a question
     * @return boolean status success/fail
     */
    public function delete_question($id){
        try {
            $sql = $this->conn->prepare("DELETE FROM tb_question WHERE id=?");
            $sql->bindValue(1, $id );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Get all question that need to display
     * @return array 
     */
    public function get_questionnaire(){
        try {
            $sql = $this->conn->prepare("SELECT A.id,A.context,C.name from tb_question A, tb_questionnaire B,tb_group C WHERE A.id=B.question_id AND C.id=A.group_num");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return $result;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Insert a question into questionnaire
     * @return boolean status success/fail
     */
    public function insert_questionnaire($id){
        try {
            $sql = $this->conn->prepare("INSERT INTO tb_questionnaire(question_id) VALUES(?)");
            $sql->bindValue(1, $id );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    /**
     * Delete a question into questionnaire
     * @return boolean status success/fail
     */
    public function delete_questionnaire($id){
        try {
            $sql = $this->conn->prepare("DELETE FROM tb_questionnaire WHERE question_id=?");
            $sql->bindValue(1, $id );
            if($sql->execute()){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    
    /**
     * Insert feedback
     * @param int $question_id 
     * @param int $option_id 
     * @return boolean status success/fail
     */
    public function insert_feedback($question_id, $option_id){
        try {
            $sql = $this->conn->prepare("INSERT INTO tb_feedback(question_id, option_id) VALUE(?,?)");
            $sql->bindValue(1, $question_id );
            $sql->bindValue(2, $option_id );
            
            $sql2 = $this->conn->prepare("UPDATE tb_option SET amount = amount + 1 WHERE id=?");
            $sql2->bindValue(1, $option_id );
            
            if($sql->execute() && $sql2->execute() ){
//                if($sql2->execute() ){
                return true;
            }else{
                return false;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }

    public function get_fbsum_by_option(){
        try {
            $sql = $this->conn->prepare("SELECT id,amount FROM tb_option ");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            if($result = $sql->fetchAll()){
                return $result;
            }else{
                return null;
            }
        } catch (PDOException $e) {
            die("authentication error!");
            echo "Error: " . $e->getMessage();
        }
    }
    
    
}
