<?php
header( "Content-Type: application/json; charset=UTF-8" );

require_once( '../config/config.php' );
$datas = json_decode( stripslashes( file_get_contents( "php://input" ) ), true );
$metadatas = $datas[ 'metadata' ];
$filedatas = $datas[ 'file' ];
$file = $filedatas[ '1' ];
$pic_id = $file[ 'pic_id' ];

foreach ( $metadatas as $anno_idx => $metadata ) {
  if ( !empty( $metadata ) ) {
    $obj_id = '';
    foreach ( $metadata[ 'av' ] as $key => $value ) {
      $obj_id = $value;
    }

    $xy = json_encode( $metadata[ 'xy' ] );

    $sql = "Insert annotations (ANNOTATION_IDX, PIC_ID, OBJECT_ID, POINTS) values ('$anno_idx', '$pic_id', '$obj_id', '$xy') ";
    $conn->query( $sql );
    $insert_id = $conn->insert_id;


  }

}

$update_sql = "UPDATE pictures SET TO_ANNOTATE = 0 WHERE PIC_ID = $pic_id";
$conn->query( $update_sql );

echo json_encode( "ok" );

?>