<?php
session_start();
require_once 'includes/auth_validate.php';
require_once 'config/config.php';
$cust_id = filter_input(INPUT_POST, 'cust_id');
$emp_id =   filter_input(INPUT_POST, 'spnEmp');
$taskdesc = filter_input(INPUT_POST, 'taskdesc');
$taskId = "TSK-".generateRandomString(4);




if ($cust_id && $_SERVER['REQUEST_METHOD'] == 'POST') 
{

	if($_SESSION['admin_type']!='super'){
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
   $status =  $db->insert ('tasklist', $data_to_store);
  
    
    if ($status) 
    {
        $_SESSION['info'] = "Task assign successfully!";
        header('location: customers.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Unable to assing task";
    	header('location: customers.php');
        exit;

    }
    
}


?>
