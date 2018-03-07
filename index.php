<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';


//Get Dashboard information
$numCustomers = $db->getValue("customers", "count(*)");

//open task Counter
$query_open = "SELECT COUNT(*) as datacount FROM tasklist where status ='open' ";
if ($_SESSION['admin_type'] == 'staff') {
    $query_open = $query_open . " and eid = '" . $_SESSION['userId'] . "' ";
}
$result_open = $db->query($query_open);
foreach ($result_open as $value) {
    $openCounter = $value['datacount'];
}

//resolve task Counter
$query_resolve = "SELECT COUNT(*) as datacount FROM tasklist where status ='resolved' ";
if ($_SESSION['admin_type'] == 'staff') {
    $query_resolve = $query_resolve . "and eid = '" . $_SESSION['userId'] . "' ";
}

$result_resolve = $db->query($query_resolve);
foreach ($result_resolve as $value) {
    $resolveCounter = $value['datacount'];
}
//close task Counter
$query_close = "SELECT COUNT(*) as datacount FROM tasklist where status ='closed' ";
if ($_SESSION['admin_type'] == 'staff') {
    $query_close = $query_close . "and eid = '" . $_SESSION['userId'] . "' ";
}
$result_close = $db->query($query_close);
foreach ($result_close as $value) {
    $closedCounter = $value['datacount'];
}

if ($_SESSION['admin_type'] == 'staff') {
    $query = "SELECT COUNT(*) as datacount FROM tasklist where eid = '" . $_SESSION['userId'] . "'";
    $result = $db->query($query);
    foreach ($result as $value) {
        $taskCounter = $value['datacount'];
    }
} else
    $taskCounter = $db->getValue("tasklist", "count(*)");

include_once('includes/header.php');
?>

<script src="assets/js/highcharts.js"></script>

<script>
    var chart;
    $(document).ready(function () {
        chart = new Highcharts.Chart(
                {

                    chart: {
                        renderTo: 'mygraph',
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false
                    },
                    title: {
                        text: ''
                    },
                    tooltip: {
                        formatter: function () {
                            return '<b>' +
                                    this.point.name + '</b>: <br/>' + Highcharts.numberFormat(this.percentage, 2) + ' % ';
                        }
                    },

                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: 'pointer',
                            dataLabels: {
                                enabled: true,
                                color: '#000000',
                                connectorColor: 'green',
                                formatter: function ()
                                {
                                    return '<b>' + this.point.name + '</b>: <br/>'
                                            + Highcharts.numberFormat(this.percentage, 2) + ' % ';
                                }
                            }
                        }
                    },

                    series: [{
                            type: 'pie',
                            name: 'Task Chart',
                            data: [
                                [
                                    '<?php echo 'Open '; ?>',<?php echo $openCounter; ?>
                                ],
                                [
                                    '<?php echo 'Resolve '; ?>',<?php echo $resolveCounter; ?>
                                ],
                                [
                                    '<?php echo 'Close '; ?>',<?php echo $closedCounter; ?>
                                ],
                            ]
                        }]
                });
    });
</script>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div> 
    <!-- /.row -->
    <div class="row">
        <?php if ($_SESSION['admin_type'] == 'admin') { ?>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?php echo $numCustomers; ?></div>
                                <div>Total Customers</div>
                            </div>
                        </div>
                    </div>
                    <a href="customers.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        <?php } ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $taskCounter; ?></div>
                            <div>Total Tasks!</div>
                        </div>
                    </div>
                </div>
                <a href="taskList.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <?php //if ($_SESSION['admin_type'] == 'staff') { ?>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div  class="row">
                        <i class="fa fa-address-book"></i>&nbsp;Task Summary
                        </div>
                </div>
                  <div class="panel-footer">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th align="center" class="header">Open</th>
                            <th align="center">Resolve</th>
                            <th align="center">Closed</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center"><?php echo $openCounter; ?></td>
                            <td align="center"><?php echo $resolveCounter; ?></td>
                            <td align="center"><?php echo $closedCounter; ?></td>
                        </tr>

                    </tbody>
                </table></div></div>

        </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">Task Graph </div>
                    <div class="panel-body">
                        <div id ="mygraph"></div>
                    </div>
                </div>
            </div>
        
        <?php //} ?>
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
        <div class="col-lg-4">

            <!-- /.panel .chat-panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
