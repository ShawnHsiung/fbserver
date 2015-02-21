<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DB_Connect
 *
 * @author Shawn
 */
//require_once './config.php';
class DB_Connect {
        
    private $conn;
 
    public function __construct() {    
        
        include_once dirname(__FILE__) . '/Config.php';
        
        try {
            $this->conn = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e){
          echo "Connection failed: " . $e->getMessage();
        }
    }
    public function get_conn() {
        return $this->conn;
    }
    /**
     * Destructor
     * -close a DB connection
     */
    function __destruct() {
        $this->conn = null;
    }
 
    
}
