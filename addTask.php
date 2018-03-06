<?php
session_start();
require_once 'includes/auth_validate.php';
require_once 'config/config.php';
$cust_id = filter_input(INPUT_POST, 'cust_id');
$emp_id = filter_input(INPUT_POST, 'spnEmp');
$taskdesc = filter_input(INPUT_POST, 'taskdesc');
$taskId = random_string(8);

if ($cust_id && $_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_SESSION['admin_type'] == 'staff') {
        $_SESSION['failure'] = "You don't have permission to perform this action";
        header('location: customers.php');
        exit;
    }

    $data_to_store['cid'] = $cust_id;
    $data_to_store['eid'] = $emp_id;
    $data_to_store['taskId'] = $taskId;
    $data_to_store['taskInfo'] = $taskdesc;
    $data_to_store['createdAt'] = date('Y-m-d H:i:s');
    $data_to_store['status'] = 'open';
    // $db->where('id', $customer_id);
    //   $status = $db->delete('customers');
    $status = $db->insert('tasklist', $data_to_store);


    if ($status) {
        $_SESSION['info'] = "Task assign successfully!";
        if ($_SESSION['page_name'] == "customerList") {
            header('location: customers.php');
        } else if ($_SESSION['page_name'] == "addtaskList") {
            header('location: addTask.php');
        }
        exit;
    } else {
        $_SESSION['failure'] = "Unable to assing task";
        if ($_SESSION['page_name'] == "customerList") {
            header('location: customers.php');
        } else if ($_SESSION['page_name'] == "addtaskList") {
            header('location: addTask.php');
        }
        exit;
    }
}

require_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h2 class="page-header">Create Task</h2>
        </div>
    </div>
    <?php
    include('./includes/flash_messages.php');
    $_SESSION['page_name'] = "addtaskList";
    ?>
    <!-- Success message -->
    <form class="well form-horizontal" action=" " method="post"  id="contact_form" enctype="multipart/form-data">
        <?php include_once './includes/forms/addtask_form.php'; ?>
    </form>
</div>




<?php include_once 'includes/footer.php'; ?>