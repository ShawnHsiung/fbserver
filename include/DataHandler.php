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
    /**
     * Checking admin login
     * @param String $username Admin login id
     * @param String $password Admin login password
     * @return boolean User login status success/fail
     * @return String the reasons of fail
     */
    public function check_login($username, $password) {
        
        try {
            $sql = $this->conn->prepare("SELECT password FROM tb_user WHERE username=?");
            $sql->bindValue(1, $username );
            $sql->execute();
            if($row = $sql->fetch()){
                //$boolmatch = PassHash::check_password($row['password'], $password);
                $boolmatch = $row['password'] === $password;
                if($boolmatch){
                    return true;
                }else{
                    return 'Invaild password!';
                }
            }else{
                return 'Invaild username!';
            }
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
            $sql = $this->conn->prepare("SELECT * from tb_group");
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
    public function delete_group($id){
        try {
            $sql = $this->conn->prepare("DELETE FROM tb_group WHERE id=?");
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
     * Add a question
     * @param String $text question item
     * @param int $groupId the group that question belong
     * @return boolean  status success/fail
     */
    public function add_question($text, $groupId){
        try {
            $sql = $this->conn->prepare("INSERT INTO tb_question(context, group_num) VALUES(?,?)");
            $sql->bindValue(1, $text );
            $sql->bindValue(2, $groupId );
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
            $sql = $this->conn->prepare("SELECT A.id,A.context from tb_question A, tb_questionnaire B WHERE A.id=B.question_id");
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

    
}
