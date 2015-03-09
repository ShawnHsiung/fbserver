<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Feedback Admin</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap core CSS -->
        <link href="./client/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="./client/css/signin.css" rel="stylesheet">
<!--        <script src="./js/jquery-1.11.2.js"></script>
        --><script src="./js/feedback.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                <form class="form-signin"  method="post" action="./login">
                <!--<div class="form-signin">-->
                <h2 class="form-signin-heading"> Sign in</h2>
                <p>Username<input type="text" name="username" class="form-control" required="" placeholder="Enter your username" autofocus></p> 
                <p>Password<input type="password" name="password" required="" class="form-control" placeholder="Password" ></p> 
                <div class="checkbox">
                  <label><input type="checkbox" name="remember" value="remember-me"> Remember me</label>
                </div>
                <input value="Sign in" id="login" class="btn btn-lg btn-primary btn-block" type="submit" /> 
                <!--<button class="btn btn-lg btn-primary btn-block" name="login" id="login" type="submit" >Sign in</button>-->
                
                <div id="info">
                    <?if(!empty($msg_error)):?><p class="error"><?=$msg_error?></p>
                    <?endif;?>
                </div> 
                </form>
                </div>
                <!--</div>-->
            </div>
        </div> <!-- /container -->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!--//<script src="../js/ie10-viewport-bug-workaround.js"></script>-->
        </body>
</html>