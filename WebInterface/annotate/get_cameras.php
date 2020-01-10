<?php
require_once('../config/config.php');
$client_id  = $_GET['client_id'];

$sql = "SELECT * from cameras where CLIENT_ID='$client_id'";
$result = $conn->query($sql);
// $return = $result->fetch_array(MYSQLI_ASSOC);
$return = array();
while ($row = $result->fetch_assoc()) {
    array_push($return, $row);
}

echo json_encode($return);
