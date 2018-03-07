<?php

include '../config/config.php';
//require_once '../includes/auth_validate.php';
global $registerDeviceId;
$action = $_REQUEST['action'];
//echo $servername;
switch ($action) {

    case 'login':
        getLogin();
        break;
    case 'menus':
        getMenus();
        break;
    case 'placeorder':
        placeorder();
        break;
    case 'getOrderList':
        getOrderList();
        break;
    case 'tasklist':
        getTaskList();
        break;
    default :
        break;
}

function getLogin() {
    global $db;
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];


    $registerDeviceId = $_REQUEST['registerId'];

    $sql_login = "select * from admin_accounts where user_name='" . $username . "' and passwd='" . $password . "'";
    $result_login = $db->query($sql_login);
    foreach ($result_login as $value) {
        $userID = $value['id'];
    }


    // update the login table to store regiter token to sent notification
    $data_to_update['deviceId'] = $registerDeviceId;
    $db->where('id', $userID);
    $stat = $db->update('admin_accounts', $data_to_update);


    //again search for json
    $result_login = $db->query($sql_login);
    foreach ($result_login as $value) {
        $userID = $value['id'];
    }



    //open task Counter
    $query_open = "SELECT COUNT(*) as datacount FROM tasklist "
            . "where eid = '" . $userID . "' and status ='open'";
    $result_open = $db->query($query_open);
    foreach ($result_open as $value) {
        $openCounter = $value['datacount'];
    }

    //resolve task Counter
    $query_resolve = "SELECT COUNT(*) as datacount FROM tasklist "
            . "where eid = '" . $userID . "' and status ='resolved'";

    $result_resolve = $db->query($query_resolve);
    foreach ($result_resolve as $value) {
        $resolveCounter = $value['datacount'];
    }
    //close task Counter
    $query_close = "SELECT COUNT(*) as datacount FROM tasklist "
            . "where eid = '" . $userID . "' and status ='closed'";
    $result_close = $db->query($query_close);
    foreach ($result_close as $value) {
        $closedCounter = $value['datacount'];
    }

    if (count($result_login) > 0) {
        $data['message'] = true;
        $data['taskOpen'] = $openCounter;
        $data['taskResolve'] = $resolveCounter;
        $data['taskClosed'] = $closedCounter;
        $data['userdata'] = $result_login[0];
    } else {
        $data['message'] = false;
        $data['errorMessage'] = 'User not exists';
    }


    if ($stat) {
        print json_encode($data);
        header("Content-type:application/json");
    } else {
        echo 'device registration fail...';
    }

//    
//    $jsonData = array();
//
//    foreach ($result as $row1) {
//        $jsonData[] = $row1;
//    }
//
//    if (count($jsonData) <= 0)
//        $data = array('message' => "fail");
//    else {
//        $data['message'] = 'sucess';
//        $data['userdata'] = $result;
//        //$data['menus'] = getMenus();
//    }
}

function getMenus() {
    $menu_data = array();

    $sql_login = "SELECT * FROM menus mm,menutype mt WHERE mm.type = mt.menutype_id ";
    $result = mysql_query($sql_login);
    $jsonData = array();
    $data1 = array();
    while ($array = mysql_fetch_array($result)) {
        $jsonData['id'] = $array['menu_id'];
        $jsonData['name'] = $array['menuname'];
        $jsonData['desc'] = strip_tags($array['desc_menu']);
        $jsonData['image'] = $array['image'];
        $jsonData['type'] = $array['types'];
        $jsonData['price'] = $array['price'];

        array_push($data1, $jsonData);
    }
    $type_array = array($row['types'] => $data1);
    array_push($menu_data, $type_array);



    $data = array('menus' => $menu_data);
    return $data1; //json_encode($data); 
}

function getTaskList() {
    global $db;
    $empId = $_REQUEST['eid'];
    $query = "select * from tasklist TL,customers cust,admin_accounts login WHERE TL.eid = login.id and TL.cid=cust.id "
            . "and login.id='" . $empId . "'";
    // echo "==>".$query;
    $result = $db->query($query);



    if (count($result) > 0) {
        $data['message'] = true;
        $taskList = array();
        foreach ($result as $value) {

            $entery['custName'] = $value['f_name'] . " " . $value['l_name'];
            $entery['taskId'] = $value['taskId'];
            $entery['taskInfo'] = $value['taskInfo'];
            $entery['status'] = $value['status'];
            $entery['address'] = $value['address'];
            $entery['createdAt'] = $value['createdAt'];
            array_push($taskList, $entery);
        }
        $data['taskList'] = $taskList;
    } else {
        $data['message'] = false;
        $data['errorMessage'] = 'No task available';
    }
    print json_encode($data);
    header("Content-type:application/json");
}

function placeorder() {
    $empid = $_REQUEST['empId'];

    $completeTime = "0000-00-00 00:00:00";
    $date = date('Y-m-d H:i:s');
    $order_no = random_string(6);

    $itemJson = json_decode(stripslashes($_REQUEST['item_json']), true);
    foreach ($itemJson['order'] as $item) {

        if ($item['item_type'] == "Veg") {
            $menutype_id = "1";
        } else {
            $menutype_id = "2";
        }

        $sql = "insert into  menu_order (menuid, empid, orderplacetime, complet_time, amount, menutype_id,quantity,order_no) "
                . "values('" . $item['item_id'] . "', '" . $empid . "', '" . $date . "', '" . $completeTime . "', '" . $item['price'] . "'"
                . ", '" . $menutype_id . "', '" . $item['item_quantity'] . "','" . $order_no . "')";

        $result = mysql_query($sql);
    }

    if ($result == true) {
        $data = array('message' => "success", "order_no" => $order_no);
        print json_encode($data);
    } else {
        $data = array('message' => "fail");
        print json_encode($data);
    }
    // echo "sgsgs ".$_REQUEST['item_json'];
    //print_r($itemJson);
}

function getOrderList() {

    $empid = $_REQUEST['empid'];
    $order_date = $_REQUEST['order_date'];

    $date_array = array();
    $array_temp = array();
    $sql_date = "SELECT DISTINCT order_no,orderplacetime,empid FROM menu_order WHERE DATE(orderplacetime)='" . $order_date . "'";
    // echo 'dfsd ' .$sql_date;
    $result_date = mysql_query($sql_date);

    $row_count = mysql_num_rows($result_date);

    //echo '<br/>row count '.$row_count;
    //exit;
    if ($row_count >= 1) {
        while ($row_date = mysql_fetch_array($result_date)) {

            if ($empid == $row_date['empid']) {

                $date_array['orderplacetime'] = $row_date['orderplacetime'];
                $sql_orderlist = "SELECT * FROM menu_order mo,employee emp,menus m,menutype mt WHERE mo.menutype_id = mt.menutype_id
AND mo.empid = emp.emplyoee_id AND mo.menuid = m.menu_id AND mo.empid='" . $empid . "'"
                        . " AND DATE(mo.orderplacetime) = '" . $order_date . "' AND mo.order_no ='" . $row_date['order_no'] . "' ";
//echo "==> ".$sql_orderlist."<br/>";
                $result = mysql_query($sql_orderlist);
                $jsonData = array();
                $data1 = array();
                while ($array = mysql_fetch_array($result)) {
                    $jsonData['dates'] = $array['orderplacetime'];
                    $jsonData['name'] = $array['menuname'];
                    $jsonData['desc'] = strip_tags($array['desc_menu']);
                    $jsonData['price'] = $array['price'];
                    $jsonData['type'] = $array['type'];
                    $jsonData['quantity'] = $array['quantity'];
                    array_push($data1, $jsonData);
                    $date_array['orderlist'] = $data1;
                }
                $data_total['order_data'] = $date_array;
                array_push($array_temp, $date_array);
                $array_list['message'] = 'success';
                $array_list['order_summary'] = $array_temp;
            } else {
                $array_list['message'] = 'fail';
            }
        }
    } else {
        $array_list['message'] = 'fail';
    }

    print json_encode($array_list);
}



?>
