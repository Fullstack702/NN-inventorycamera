<?php
require_once('../config/config.php');

$sql = "SELECT * from clients";
$result = $conn->query($sql);
// $return = $result->fetch_array(MYSQLI_ASSOC);
$return = array();
while ($row = $result->fetch_assoc()) {
    array_push($return, $row);
}

echo json_encode($return);
