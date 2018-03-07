<?php
//https://inducesmile.com/android/android-firebase-cloud-messaging-push-notification-with-server-admin-in-php-and-mysql-database/
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';
$tokenArray = array();
$messageArray = array();
$query_task = "SELECT * FROM tasklist where status='open' ";
$result_task = $db->query($query_task);
foreach ($result_task as $value_task) {
    $userId = $value_task['eid'];
    $taskId = $value_task['taskId'];
    $taskInfo = $value_task['taskInfo'];
    //get device Id
    $query_deviceId = "Select deviceId from admin_accounts where id = '" . $userId . "'";
    $result_device = $db->query($query_deviceId);
    foreach ($result_device as $valueDevice) {
        $token = $valueDevice['deviceId'];
        $msg = "Your task is open for taskId " . $taskId . " <br/> Task Infor " . $taskInfo;
        $message = array("FCM" => $msg);
        array_push($tokenArray, $token);
        array_push($messageArray, $message);
          $jsonString = sendPushNotificationToGCMSever($tokenArray, $messageArray);
            $jsonObject = json_decode($jsonString);
    }
}

if (count($tokenArray) > 0) {
    
    $jsonString = sendPushNotificationToGCMSever($tokenArray, $messageArray);
    $jsonObject = json_decode($jsonString);
//echo "userId ".$userId." TaskId ".$taskId." taskInfo ".$taskInfo;
    echo "<br/> token " . $token . "<br/><br/>";
  //  echo '$jsonString := ' . $jsonString . '<br/><br/>';


    print_r($jsonObject);
}
header('location: index.php');
?>

