<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Access-Control-Allow-Origin: *');
session_cache_limiter(false);
session_start();

require_once './include/DataHandler.php';
require './libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim(array(
    'templates.path' => './client'
));

//$app->add(new Slim_Middleware_ContentTypes());


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
        $db = new DbHandler();

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
 * Redirect to login page
 * method - GET
 */
$app->get('/', function() use ($app){
    if(isset($_SESSION['username'])){
        $app->render('home.php');
    }else{
        $app->redirect('./login');
    }
});

/**
 * Login page
 * url - /login
 * method - GET
 */
$app->get('/login', function() use ($app){
   $flash = $app->view()->getData('flash');
   $msg_error = '';
   if (isset($flash['msg_error'])) {
      $msg_error = $flash['msg_error'];
   }
   $app->render('login.php', array('msg_error' => $msg_error));
});

$app->get("/logout", function () use ($app) {
   unset($_SESSION['username']);
   $app->view()->setData('username', null);
   $app->redirect('./login');
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
    //check for correct username and password
    $result = $db->check_login($username, $password);
    if ($result['flag']) {
        //get the user by email
        $response["error"] = false;
        $response['api_key'] = $result['msg'];
        $response['message'] = 'Login succeed';
        
        $_SESSION['username'] = $username;
        $_SESSION['password'] = $password;
        $_SESSION['api_key'] = $result['msg'];
        
        $app->redirect('./');
        
    } else {
        // user credentials are wrong
        $app->flash('msg_error', $result['msg']);
        $app->redirect('/fbserver/login');
        $response['error'] = true;
        $response['message'] = 'Login failed. ' . $result['msg'];
    }
//    echoRespnse(200, $response);
});

//$app->get('/home', function () use ($app) {
//    //$app->render('home.html');
//});  

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

$app->post('/group', function() use($app){
    
    verifyRequiredParams(array('name'));
    // reading post params
    $name = $app->request()->post('name');
    //echo $name;
    $response = array();
    $db = new DataHandler();
    if($db->check_group_name($name)){
        $response['error'] = true;
        $response['message'] = 'Group name has existed!';
    }else{    
        $result = $db->add_group($name);
        if ($result) {
            $response["error"] = false;
            $response['message'] = 'Create succeed';
        } else {
            $response['error'] = true;
            $response['message'] = 'Create failed.';
        }
    }
    echoRespnse(200, $response);
});

$app->delete('/group/:name', function($name) use($app){
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->delete_group($name);
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Delete succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Delete failed.';
    }
    
    echoRespnse(200, $response);
});

/**
 * Listing question
 * method GET
 * url /question
 */
$app->get('/question', function() use($app){
    $response = array();
    $db = new DataHandler();
    
    $result = $db->get_question();
    if ($result) {
        $response["error"] = false;
        $response['message'] = $result;
    } else {
        $response['error'] = true;
        $response['message'] = 'No question existed';
    }
    echoRespnse(200, $response);
});
/**
 * get questions by group name
 * method GET
 * url /question
 */
$app->get('/question/:name', function($name) use($app) {
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->get_question_by_groupname($name);
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
 * Listing question
 * method GET
 * url /question
 */
$app->put('/question', function() use($app){
    
    verifyRequiredParams(array('id','name'));
    $id = $app->request->put('id');
    $group_name = $app->request->put('name');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->update_question_group_num($id,$group_name);
    if ($result) {
        $response["error"] = false;
        $response['message'] = $response;
    } else {
        $response['error'] = true;
        $response['message'] = 'update error';
    }
    echoRespnse(200, $response);
});
/**
 * Create a question
 * method POST
 * url /question
 * @param String $text question record
 * @param int $group_id  id of group that question belong to
 */
$app->post('/question', function() use($app){
    verifyRequiredParams(array('text', 'name'));
    // reading post params
    $text = $app->request()->post('text');
    $group_name = $app->request()->post('name');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->add_question($text, $group_name );
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Create succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Create failed.';
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
/**
 * Insert question into questionnaire
 * method POST
 * url /questionnaire
 * @param int $id question id        
 */
$app->post('/questionnaire', function() use($app){
    
    verifyRequiredParams(array('id'));
    // reading post params
    $id = $app->request()->post('id');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->insert_questionnaire($id);
    if ($result) {
        $response["error"] = false;
        $response['message'] = $result;
    } else {
        $response['error'] = true;
        $response['message'] = 'NO available questionnaire.';
    }
    
    echoRespnse(200, $response);
});

$app->delete('/questionnaire/:id', function($id) use($app){
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->delete_questionnaire($id);
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Delete succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Delete failed.';
    }
    
    echoRespnse(200, $response);
});


$app->get('/feedback', function() use($app){
    
    $response = array();
    $db = new DataHandler();
    $result = $db->get_fbsum_by_option();
    
    if ($result) {
        $response["error"] = false;
        $response['message'] = $result;
    } else {
        $response['error'] = true;
        $response['message'] = 'NO any feedback.';
    }
    
    echoRespnse(200, $response);
     
});

$app->post('/feedback', function() use($app){
    //verifyRequiredParams(array('data'));
//    $input = array();
//    $input =$app->request()->getBody();
    //$input =$app->request()->post('user');
    //parse_str($app->request()->getBody(), $input);
    //$input = json_decode($input);
    //$input = urldecode($input);
    //$input = json_decode($input);
    
   verifyRequiredParams(array('question_id','option_id'));

    // reading post params
    $question_id = $app->request()->post('question_id');
    $option_id = $app->request()->post('option_id');
    
    $response = array();
    $db = new DataHandler();
    
    $result = $db->insert_feedback($question_id,$option_id);
    if ($result) {
        $response["error"] = false;
        $response['message'] = 'Succeed';
    } else {
        $response['error'] = true;
        $response['message'] = 'Failed';
    }
    echoRespnse(200, $response);
});
$app->run();