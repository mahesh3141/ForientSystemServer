<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Only super admin is allowed to access this page
/*if ($_SESSION['admin_type'] !== 'admin') {
    // show permission denied message
    header('HTTP/1.1 401 Unauthorized', true, 401);

    exit("401 Unauthorized");
}*/
//Get data from query string
$search_string = filter_input(INPUT_GET, 'search_string');
$del_id = filter_input(INPUT_GET, 'del_id');

$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$page = filter_input(INPUT_GET, 'page');
$pagelimit = 10;
if ($page == "") {
    $page = 1;
}
// If filter types are not selected we show latest added data first
if ($filter_col == "") {
    $filter_col = "id";
}
if ($order_by == "") {
    $order_by = "desc";
}
// select the columns
$tableColumn = array('id', 'cid', 'eid', 'taskId', 'taskInfo', 'createdAt', 'status');
$select = array('id', 'taskId', 'createdAt', 'status');
$select_data = array('ID', 'Task ID', 'Created Date', 'Status');

// If user searches 
if ($search_string) {
    $db->where('taskId', '%' . $search_string . '%', 'like');
    $db->orwhere('status', '%' . $search_string . '%', 'like');
    $db->orwhere('eid', '%' . $search_string . '%', 'like');
}


if ($order_by) {
    $db->orderBy($filter_col, $order_by);
}
if ($_SESSION['admin_type'] == 'staff') {
    $db->where('eid',$_SESSION['userId']);
}
$db->pageLimit = $pagelimit;
$result = $db->arraybuilder()->paginate("tasklist", $page, $tableColumn);
$total_pages = $db->totalPages;


// get columns for order filter
foreach ($result as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}


include_once 'includes/header.php';
?>

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-6">
            <h1 class="page-header">Task List</h1>
        </div>
        <?php if ($_SESSION['admin_type'] == 'admin') { ?>
            <div class="col-lg-6">
                <div class="page-action-links text-right">
                    <a href="addTask.php"> <button class="btn btn-success">Create Task</button></a>
                </div>
            </div>
        <?php } ?>
    </div>
    <?php include('./includes/flash_messages.php') ?>

    <?php
    if (isset($del_stat) && $del_stat == 1) {
        echo '<div class="alert alert-info">Successfully deleted</div>';
    }
    ?>

    <!--    Begin filter section-->
    <div class="well text-center filter-form">
        <form class="form form-inline" action="">
            <label for="input_search" >Search</label>
            <input type="text" class="form-control" id="input_search"  
                   placeholder="Enter task id" 
                   name="search_string" value="<?php echo $search_string; ?>">
            <label for ="input_order">Order By</label>
            <select name="filter_col" class="form-control">

                <?php
                $index = 0;
                foreach ($select as $option) {
                    ($filter_col === $option) ? $selected = "selected" : $selected = "";
                    echo ' <option value="' . $option . '" ' . $selected . '>' . $select_data[$index] . '</option>';
                    $index++;
                }
                ?>

            </select>

            <select name="order_by" class="form-control" id="input_order">

                <option value="Asc" <?php
                if ($order_by == 'Asc') {
                    echo "selected";
                }
                ?> >Asc</option>
                <option value="Desc" <?php
                if ($order_by == 'Desc') {
                    echo "selected";
                }
                ?>>Desc</option>
            </select>
            <input type="submit" value="Go" class="btn btn-primary">

        </form>
    </div>
    <!--   Filter section end-->
    <hr>
    <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th class="header">Emp ID</th>
                <th>Task Id</th>
                <th>Employee Name</th>
                <th>Customer Name</th>
                <th>Task description</th>
                <th>Created Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            <?php foreach ($result as $row) : ?>

                <tr>
                    <td><?php echo $row['eid'] ?></td>
                    <td><?php echo htmlspecialchars($row['taskId']) ?></td>
                    <td><?php
                        //get employee name
                        $enam_query = "select * from admin_accounts where id='" . $row['eid'] . "'";
                        $empResult = $db->query($enam_query);
                        foreach ($empResult as $value) {
                            echo htmlspecialchars($value['fname'] . " " . $value['lname']);
                        }
                        ?></td>
                    <td><?php
                        //get customer name
                        $cust_query = "select * from customers where id='" . $row['cid'] . "'";
                        $custResult = $db->query($cust_query);
                        foreach ($custResult as $value) {
                            echo htmlspecialchars($value['f_name'] . " " . $value['l_name']);
                        }
                        ?></td>
                    <td><?php echo htmlspecialchars($row['taskInfo']) ?></td>
                    <td><?php
                        $date = strtotime($row['createdAt']);
                        echo htmlspecialchars(date("j M Y", $date));
                        ?></td>
                    <td><?php echo ucfirst(htmlspecialchars($row['status'])) ?></td>
                    <td>

                        <a href="edit_admin.php?admin_user_id=<?php echo $row['id'] ?>&operation=edit" 
                           title="Change Status" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></a>
                           <?php
                           //Only super admin is allowed to change the status of task
                           if ($_SESSION['admin_type'] == 'admin') {
                               ?>
                            <a href=""  title="Delete Task" class="btn btn-danger delete_btn" 
                               data-toggle="modal" data-target="#confirm-delete-<?php echo $row['id'] ?>" style="margin-right: 8px;">
                                <span class="glyphicon glyphicon-trash"></span>
                            <?php } ?>
                    </td>
                </tr>
                <!-- Delete Confirmation Modal-->
            <div class="modal fade" id="confirm-delete-<?php echo $row['id'] ?>" role="dialog">
                <div class="modal-dialog">
                    <form action="delete_task.php" method="POST">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Confirm</h4>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="del_id" id = "del_id" value="<?php echo $row['id'] ?>">
                                <p>Are you sure you want to delete this user?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-default pull-left">Yes</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        <?php endforeach; ?>   
        </tbody>
    </table>
    <!--    Pagination links-->
    <div class="text-center">

        <?php
        if (!empty($_GET)) {
            //we must unset $_GET[page] if built by http_build_query function
            unset($_GET['page']);
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="index.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
</div>
<?php include_once 'includes/footer.php'; ?>