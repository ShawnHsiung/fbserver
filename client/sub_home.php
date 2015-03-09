<!-- /.row -->

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="glyphicon glyphicon-home"></i> <a href="/fbserver">Home</a>
            </li>
        </ol>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-thumbs-o-up fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div id="option_1" class="huge">1</div>
                            <div>Great</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-smile-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div id="option_2" class="huge">1</div>
                            <div>Very Good</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-meh-o fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div id="option_3" class="huge">1</div>
                            <div>Good</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-thumbs-o-down fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div id="option_4" class="huge">1</div>
                            <div>Bad</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Pie Chart</h3>
                </div>
                <div class="panel-body">
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart"></div>
                    </div>
    <!--                                <div class="text-right">
                        <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flot Charts JavaScript -->
    <!--[if lte IE 8]><script src="js/excanvas.min.js"></script><![endif]-->
    <script src="./client/js/plugins/flot/jquery.flot.js"></script>
    <script src="./client/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="./client/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="./client/js/plugins/flot/jquery.flot.pie.js"></script>
    <!--<script src="./js/plugins/flot/flot-data.js"></script>-->

<script src="./client/js/flot-data.js"></script>