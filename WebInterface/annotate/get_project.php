<?php

$pic_id = $_GET['pic_id'];
$direction = isset($_GET['direction']) ? $_GET['direction'] : 0;

if (isset($_GET["to_annotate"])) $to_annotate = $_GET["to_annotate"];
if (isset($_GET["analyzed"])) $analyzed = $_GET["analyzed"];
if (isset($_GET["ignored"])) $ignored = $_GET["ignored"];
if (isset($_GET["camera_id"])) $camera_id = $_GET["camera_id"];

require_once('../config/config.php');
if($direction == -1){
  $sql_select = "SELECT * from pictures where PIC_ID<$pic_id AND `TO_ANNOTATE`='$to_annotate' AND `IGNORE`='$ignored' AND `ANALYZED`='$analyzed'  AND CAM_ID_LOCAL=$camera_id order by PIC_ID desc";
}
else if ($direction  == 1 ){
  $sql_select = "SELECT * from pictures where PIC_ID>$pic_id AND `TO_ANNOTATE`='$to_annotate' AND `IGNORE`='$ignored' AND `ANALYZED`='$analyzed' AND CAM_ID_LOCAL=$camera_id";
}
else{
  $sql_select = "SELECT * from pictures where PIC_ID='$pic_id'";
}

// echo $sql_select; 
$result_select = $conn->query($sql_select);
if(!$result_select && $direction != 0)
  $result_select = $conn->query("SELECT * from pictures where PIC_ID='$pic_id'");

$imgInfo = $result_select->fetch_array(MYSQLI_ASSOC);
$cam_id_local = $imgInfo['CAM_ID_LOCAL'];
$pic_id  = $imgInfo['PIC_ID'];

$camera_select = "SELECT * from cameras where CAM_ID_LOCAL='$cam_id_local'";
$camera_result = $conn->query($camera_select);
$cameraInfo = $camera_result->fetch_array(MYSQLI_ASSOC);
$client_id = $cameraInfo['CLIENT_ID'];


$client_select = "SELECT * from clients where CLIENT_ID='$client_id'";
$client_result = $conn->query($client_select);
$clientInfo = $client_result->fetch_array(MYSQLI_ASSOC);
$client_name = $clientInfo['CLIENT_NAME'];

$objgroups_select = "SELECT * from object_groups";
$objgroups_result = $conn->query($objgroups_select);
$attribute = array();
while ($row = $objgroups_result->fetch_assoc()) {
  $attr_item = array();
  $obj_group_id = $row['OBJECT_GROUP_ID'];
  $attr_item['aname'] = $row['OBJECT_GROUP_NAME_EN'];
  $attr_item['anchor_id'] = "FILE1_Z0_XY1";
  $attr_item['type'] = 3;
  $attr_item['desc'] = "";
  $attr_item['default_option_id'] = "";

  $objects_select = "SELECT objects.* 
  from objects 
  inner join objects_to_groups on objects_to_groups.OBJECT_ID=objects.OBJECT_ID
  where objects_to_groups.OBJECT_GROUP_ID='$obj_group_id'";

  $objects_result = $conn->query($objects_select);
  $options = array();
  if ($objects_result) {
    while ($obj = $objects_result->fetch_assoc()) {
      $client_ids = explode(',', $obj['CLIENTS_USING_IT']);
      if (in_array($client_id, $client_ids)) {
        $obj_id = $obj['OBJECT_ID'];
        $options[$obj_id] = $obj['OBJ_NAME_EN'];
      }
    }
  }
  $attr_item['options'] = $options;
  $attribute[$obj_group_id] = $attr_item;
}

$metadata = array();
$metadata_sql = "select * from annotations where PIC_ID='$pic_id'";
$metadata_result = $conn->query($metadata_sql);
if ($metadata_result) {
  while ($row = $metadata_result->fetch_assoc()) {
    $annotation_idx = $row['ANNOTATION_IDX'];
    $points = preg_replace("/\[|\]/", '', $row['POINTS']);
    $points_arr = explode(',', $points);
    $temp = [
      "vid" => "1",
      "flg" => 0,
      "z" => [],
      "xy" => $points_arr,
      "av" => [
        "1" => "0"
      ],
      "annotation_id" =>  $row['ANNOTATION_ID']
    ];
    $metadata[$annotation_idx] = $temp;
  }
}


  $fname = $imgInfo['FILENAME'];
  $src = 'https://inventocam.com' . $image_path . '/' . $imgInfo['FILENAME'];


$data_obj = [
  "project" => [
    "pid" => $client_id,
    "rev" => 0,
    //    "rev" => "__VIA_PROJECT_REV_ID__",
    //    "rev_timestamp" => "__VIA_PROJECT_REV_TIMESTAMP__",
    "rev_timestamp" => 0,
    "pname" => $client_name,
    "creator" => "VGG Image Annotator (http://www.robots.ox.ac.uk/~vgg/software/via)",
    "created" => 0,
    "vid_list" => [
      "1"
    ]
  ],
  "config" => [
    "file" => [
      "loc_prefix" => [
        "1" => "",
        "2" => "",
        "3" => "",
        "4" => "",
      ]
    ],
    "ui" => [
      "file_content_align" => "center",
      "file_metadata_editor_visible" => true,
      "spatial_metadata_editor_visible" => true,
      "spatial_region_label_attribute_id" => ""
    ]
  ],

  "attribute" => $attribute,

  "file" => [
    "1" => [
      "fid" => "1",
      "fname" => $fname,
      "type" => 2,
      "loc" => 2,
      "src" => $src,
      "pic_id" => $pic_id
    ]
  ],
  //  "metadata" => $metadata,
  "metadata" => ["" => []],

  "view" => [
    "1" => [
      "fid_list" => [
        "1"
      ]
    ]
  ]
];

echo json_encode($data_obj, JSON_NUMERIC_CHECK);
//echo json_encode( $data_obj, JSON_UNESCAPED_SLASHES, JSON_NUMERIC_CHECK );
