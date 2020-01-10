<!--<html>
<head>
<title>Pictures List</title>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel='stylesheet' href="../config/style.css"/>
</head>
<body>
<div id="container">
-->
<?php
$start_list = 0;
$end_list = 1000;
$to_annotate = 1;
$analyzed = 0;
$ignored = 0;
$ignore_set_id = 0;
$ignore_set_to = 0;
if (isset($_GET["start"])) $start_list = $_GET["start"];
if (isset($_GET["end"])) $end_list = $_GET["end"];
if (isset($_GET["to_annotate"])) $to_annotate = $_GET["to_annotate"];
if (isset($_GET["analyzed"])) $analyzed = $_GET["analyzed"];
if (isset($_GET["ignored"])) $ignored = $_GET["ignored"];
if (isset($_GET["set_ignore_id"])) $ignore_set_id = $_GET["set_ignore_id"];
if (isset($_GET["set_ignore_to"])) $ignore_set_to = $_GET["set_ignore_to"];
// $client_id = isset($_GET["client_id"]) ? $_GET["client_id"] : 0;
$camera_id = isset($_GET["camera_id"]) ? $_GET["camera_id"] : 0;

require_once('../config/config.php');
if ($ignore_set_id > 0) {
	echo "set ID: " . $ignore_set_id . " to: " . $ignore_set_to;
	$sql_update_ignore = "UPDATE `pictures` SET `IGNORE`=$ignore_set_to WHERE `PIC_ID`=$ignore_set_id";
	$result_update_ignore = $conn->query($sql_update_ignore);
	echo " update result: " . $result_update_ignore;
} else {
	$sql_select = "SELECT `PIC_ID`, `CAM_ID_LOCAL`,`ANALYZED`,`IGNORE`,`TO_ANNOTATE`, `FILENAME` , TIME_INCOMING 
    FROM `pictures`    
	WHERE `TO_ANNOTATE`='$to_annotate' AND `IGNORE`='$ignored' AND `ANALYZED`='$analyzed'";
	
	// if($camera_id > 0)
	$sql_select = $sql_select." AND CAM_ID_LOCAL='$camera_id'";
	$sql_select = $sql_select."  order by PIC_ID";
	$sql_select = $sql_select."  LIMIT $start_list,$end_list";
	
	$result_select = $conn->query($sql_select);
	if ($result_select->num_rows > 0) {
		// output data of each row
		$column_counter = 0;
		$columns = 3;
		while ($row = $result_select->fetch_assoc()) {
			$filename = $row["FILENAME"];
			$img_path = $image_path . "/" . $filename;
			$pic_id = $row["PIC_ID"];
			$cam_id = $row["CAM_ID_LOCAL"];
			$timestamp = strtotime($row['TIME_INCOMING']);
			// $date =  preg_replace('/-|:/', '.', $row['TIME_INCOMING']);
			$date = date('d.n.y H.i', $timestamp); 

			#$cam_id_local=$row["CAM_ID_LOCAL"];
			if ($column_counter == 0) echo "<div class='section'>\n";
			echo "<div class='button third' id='div_$pic_id'>\n";
			#echo "ID: " . $row["PIC_ID"]. "<br> Analyzed: " . $row["ANALYZED"]. "<br> To Annotate: " . $row["TO_ANNOTATE"]. "<br> Ignore: " . $row["IGNORE"]. "<br> <img class='thumbnail' src='" .$img_path.  "'> \n ";
			#echo "<img class='thumbnail' src='" .$img_path.  "' onclick='select_image(\"" .$img_path. "\")'> \n<br> ";
			echo "<img class='thumbnail' src='mkthumb.php?filename=" . $filename . "' onclick='select_image(\"" . $pic_id . "\")' title='annotate'> \n<br> ";
		
			if ($ignored == 1) {
				echo "<div>
					<p>Image ID: <strong>$pic_id</strong> <span style='width:100px;'></span> Date: <strong>$date</strong></p>
					
					<p>Filename: <a href='$img_path' target='_blank'>$filename</a></p>
					<button class='button' style='font-size:20px; margin:5px; ' onclick='set_ignore_flag($pic_id,0)'>Use Image</button>
					<button class='button' style='font-size:20px; margin:5px; '  onclick='create_objects($pic_id)'>New Object</button></div>"; 

			}
			else{
				echo "<div>
				<p>Image ID: <strong>$pic_id</strong> <span style='width:100px;'></span> Date: <strong>$date</strong></p>
				
				<p>Filename: <a href='$img_path' target='_blank'>$filename</a></p>
				<button class='button' style='font-size:20px; margin:5px; ' onclick='set_ignore_flag($pic_id,1)'>Ignore</button>
				<button class='button' style='font-size:20px; margin:5px; '  onclick='create_objects($pic_id)'>New Object</button></div>"; 

			}
/* 
			if ($ignored == 1) {
				echo "<div>
				<p>Image ID: <strong>$pic_id</strong></p>
				<p>Date: <strong>date_format($row['TIME_INCOMING'],"Y.m.d H.i");</strong></p>
				<p>Filename: <a href='$img_path' target='_blank'>date_format($filename,"Y.m.d H.i");</a></p>
				<div class='button' onclick='set_ignore_flag($pic_id,0)'>don't ignore image ID $pic_id</div></div>";
			} else {
				echo "<div class='button' onclick='set_ignore_flag($pic_id,1)'>ignore image ID $pic_id</div>";
			} */
			echo "</div>\n";
			$column_counter++;
			if ($column_counter == $columns) echo "</div>\n";
			if ($column_counter == $columns) $column_counter = 0;
		}
		$result_select->close();
	} else {
		echo "0 results <br>";
		#printf("Something went wrong with SQL statement: $sql_select \n Error: %s\n", $conn->error);
	}
}

$conn->close();
?>

<!--
</div>
</body>
</html>
-->