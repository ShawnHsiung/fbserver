<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



require_once './include/DataHandler.php';
require './libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'templates.path' => './template'
));


//$app->get('/login(/)', 'login');
//$app->post('/login(/)', 'loginValidate');
//$app->get('/logout(/)', 'logout');


/**
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DataHandler();

        // get the api key
        $api_key = $headers['Authorization'];
        // validating api key
        if (!$db->isValidApiKey($api_key)) {
            // api key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Api key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserId($api_key);
        }
    } else {
        // api key is missing in header
        $response["error"] = true;
        $response["message"] = "Api key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

/**
 * Listing questionnaire
 * method GET
 * url /questionnaire          
 */
$app->get('/group', function() {
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->get_group();
    if ($result) {
        $response["error"] = false;
        $response['message'] = $result;
    } else {
        $response['error'] = true;
        $response['message'] = 'NO available group.';
    }
    
    echoRespnse(200, $response);
});


/**
 * Listing questionnaire
 * method GET
 * url /questionnaire          
 */
$app->get('/questionnaire', function() {
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->get_questionnaire();
    if ($result) {
        $response["error"] = false;
        $response['message'] = $result;
    } else {
        $response['error'] = true;
        $response['message'] = 'NO available questionnaire.';
    }
    
    echoRespnse(200, $response);
});



$app->get('/', function() use ($app){
    //$app->render('../view/login.html');
    //$app->redirect('../view/login.html');
    $app->render('login.html');
});
/**
 * User Login
 * url - /login
 * method - POST
 * params - email, password
 */
$app->post('/login', function() use ($app) {
    
    //check for required params
    verifyRequiredParams(array('username', 'password'));
    // reading post params
    $username = $app->request()->post('username');
    $password = $app->request()->post('password');

    $response = array();
    
        
    $db = new DataHandler();
    //check for correct email and password
    $result = $db->check_login($username, $password);
    if (is_bool($result) && $result) {
        //get the user by email
        //$user = $db->getUserByEmail($email);
        $response["error"] = false;
        $response['message'] = 'Login succeed'; 
        //$response['url'] = 'Login succeed';
        $app->render('home.html');
        
    } else {
        // user credentials are wrong
        $response['error'] = true;
        $response['message'] = 'Login failed. ' . $result;
    }
    //$app->render('../view/home.html');
    //$app->redirect('../view/home.html');
    //echoRespnse(200, $response);
});
        
$app->post('/group', function() use($app){
    
    verifyRequiredParams(array('name'));
    // reading post params
    $name = $app->request()->post('name');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->add_group($name);
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Create succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Create failed.';
    }
    
    echoRespnse(200, $response);
});

$app->delete('/group', function() use($app){
    
    verifyRequiredParams(array('id'));
    // reading post params
    $id = $app->request()->post('id');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->delete_group($id);
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Delete succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Delete failed.';
    }
    
    echoRespnse(200, $response);
});
      

$app->run();  