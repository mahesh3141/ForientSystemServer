<?php

//Note: This file should be include first in every php page.

define('BASE_PATH', dirname(dirname(__FILE__)));
define('APP_FOLDER', 'simpleadmin');
define('CURRENT_PAGE', basename($_SERVER['REQUEST_URI']));
define("SERVER_KEY", "AAAAf5yEtTk:APA91bFxWSrFVMxPLVwFs98M7EDZ1pf9D5Lu5P6OXXSCIS1IVgZH05T9wuDqRwJ_O9hoy3n46oEFJGY1dN0YJ1Erl4zke-1B6UbssAXC4wgQ0rPXza5OtNUiv08aDSniaHIARvMMErsD");
$firebase_path = "https://fcm.googleapis.com/fcm/send";

require_once BASE_PATH . '/lib/MysqliDb.php';
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "corephpadmin";
// create connection object
$db = new MysqliDb($servername, $username, $password, $dbname);

//default functions for some operations
function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function sendPushNotificationToGCMSever($token, $message) {
    $msgSize = sizeof($message);
    $fields = array(
        'registration_ids' => $token,
        'notification' => array('title' => 'FFS Notification', 'body' => 'Yo have '. $msgSize.' pending task'),
        'data' => array('message' => $message)
    );
    $headers = array(
        'Authorization:key=' . SERVER_KEY,
        'Content-Type:application/json'
    );
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);

    curl_close($ch);

    return $result;
}

?>