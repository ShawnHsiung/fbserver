<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Home Page</title>

    <!-- Bootstrap Core CSS -->
    <link href="./client/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap table CSS -->
    <link href="./client/css/bootstrap-table.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="./client/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="./client/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!--<link rel="stylesheet" type="text/css" href="./css/dataTables.bootstrap.css">-->


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script src="./client/js/jquery-1.11.2.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="./client/js/bootstrap.min.js"></script>
    <script src="./client/js/feedback.js"></script>
    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Admin</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu message-dropdown">
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Shawn Hsiung</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Shawn Hsiung</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-preview">
                            <a href="#">
                                <div class="media">
                                    <span class="pull-left">
                                        <img class="media-object" src="http://placehold.it/50x50" alt="">
                                    </span>
                                    <div class="media-body">
                                        <h5 class="media-heading"><strong>Shawn Hsiung</strong>
                                        </h5>
                                        <p class="small text-muted"><i class="fa fa-clock-o"></i> Yesterday at 4:32 PM</p>
                                        <p>Lorem ipsum dolor sit amet, consectetur...</p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="message-footer">
                            <a href="#">Read All New Messages</a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION['username']?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="#"><i class="fa fa-fw fa-user"></i> Profile</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-envelope"></i> Inbox</a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="/fbserver/logout"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li >
                        <a href="javaScript:void(0)" onclick="showpage(1)" ><i class="glyphicon glyphicon-home"></i> Home</a>
                        <!--<a href="index.html"><i class="fa fa-fw fa-dashboard"></i> Home</a>-->
                    </li>
                    <li>
                        <a href="javaScript:void(0)" onclick="showpage(2)" ><i class="glyphicon glyphicon-list"></i> Group</a>
                        <!--<a href="tables.html"><i class="fa fa-fw fa-table"></i> Group</a>-->
                    </li>
                    <li>
                        <a href="javaScript:void(0)" onclick="showpage(3)" ><i class="fa fa-fw fa-edit"></i> Question</a>
                        <!--<a href="forms.html"><i class="fa fa-fw fa-edit"></i> Question</a>-->
                    </li>
                    <li>
                        <a href="javaScript:void(0)" onclick="showpage(4)" ><i class="fa fa-fw fa-desktop"></i> Questionnaire</a>
                        <!--<a href="bootstrap-elements.html"><i class="fa fa-fw fa-desktop"></i> Questionnaire</a>-->
                    </li>
<!--                    <li>
                        <a href="javaScript:void(0)" onclick="showpage(5)" ><i class="fa fa-fw fa-bar-chart-o"></i> Data Analysis</a>
                        <a href="charts.html"><i class="fa fa-fw fa-bar-chart-o"></i> Data Analysis</a>
                    </li>-->
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">
            <!-- Page Heading -->
            
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    
    <script>
        showpage(1);
    </script>
    
</body>



</html>
