<?php
require_once('../config/config.php');
$file_to_upload = $_FILES['croppedImage']['tmp_name'];

$objName = $_POST['objName'];
$objGroup = $_POST['objGroup'];
$clientIds = $_POST['clientIds'];
$now = date('Y-m-d h:i:s');
$sql = "Insert objects (OBJ_NAME_EN, FILENAME, TIME_ADDED, CLIENTS_USING_IT) values ('$objName', '', '$now', '$clientIds') ";
$conn->query( $sql );
$objId = $conn->insert_id;

$objIdStr = strval($objId);

while (strlen( $objIdStr) < 10) {
    $objIdStr = '0'.$objIdStr;
}
$fileName = "Object_".$objIdStr.".png";
$update_sql = "UPDATE objects SET FILENAME = '$fileName' WHERE OBJECT_ID = $objId";
$conn->query( $update_sql );

$groupsql = "Insert objects_to_groups (OBJECT_ID, OBJECT_GROUP_ID) values ('$objId', '$objGroup')";
$conn->query( $groupsql );

$dest = $objects_path."/".$fileName;
move_uploaded_file($file_to_upload, $dest);