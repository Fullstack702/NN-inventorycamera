<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" crossorigin="anonymous">


  <link rel="icon" type="image/svg+xml" href="../config/favicon.svg" sizes="any">
  <link rel="icon" type="image/png" href="../config/favicon.png" sizes="96x96">
  <link rel="stylesheet" type="text/css" href="../config/style_imageloader.css">
  <title>Create New Objects</title>
  <link href="../config/cropper.css" rel="stylesheet">
  <link href="../config/cropper_main.css" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="multiselect/example-styles.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.css" crossorigin="anonymous" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" crossorigin="anonymous"></script> -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.min.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="multiselect/jquery.multi-select.js"></script>
  <script src="main.js"></script>
  <style>
    #image {
      display: block;
      max-width: 100%;
    }

    button em {
      font-size: 9px;
    }
  </style>
</head>

<body>
  <div class="jumbotron bg-primary text-white rounded-0" style="padding:1rem 0.5rem;">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1>Create New Object</h1>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-md-9">
        <div class="img-container">
          <?php
          require_once('../config/config.php');
          $pic_id = isset($_GET['pic_id']) ? $_GET['pic_id'] : 0;
          $sql_select = "SELECT * from pictures where PIC_ID='$pic_id'";
          $result_select = $conn->query($sql_select);
          $imgInfo = $result_select->fetch_array(MYSQLI_ASSOC);
          $filename = $imgInfo['FILENAME'];

          $cam_id = $imgInfo['CAM_ID_LOCAL'];
          echo "<input type='hidden' id='camId' value='".$cam_id.",'/>";

          $img_path = $image_path . "/" . $filename;
          echo '<img id="image"  src="' . $img_path . '">';

          ?>
        </div>
      </div>
      <div id="actions" class="col-md-3">
        <div class="docs-buttons">
          <!-- <h3>Toolbar:</h3> -->
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.setDragMode(&quot;move&quot;)">
                <span class="fa fa-arrows-alt"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.setDragMode(&quot;crop&quot;)">
                <span class="fa fa-crop-alt"></span>
              </span>
            </button>
          </div>

          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(0.1)">
                <span class="fa fa-search-plus"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.zoom(-0.1)">
                <span class="fa fa-search-minus"></span>
              </span>
            </button>
          </div>

          <!-- <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(-10, 0)">
                <span class="fa fa-arrow-left"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(10, 0)">
                <span class="fa fa-arrow-right"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(0, -10)">
                <span class="fa fa-arrow-up"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.move(0, 10)">
                <span class="fa fa-arrow-down"></span>
              </span>
            </button>
          </div> -->

          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(-45)">
                <em>45&deg;</em><span class="fa fa-undo-alt"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="-1" title="Rotate Left">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(-1)">
                <em>1&deg;</em><span class="fa fa-undo-alt"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="5" title="Rotate Right">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(5)">
                <span class="fa fa-redo-alt"></span><em>5&deg;</em>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.rotate(45)">
                <span class="fa fa-redo-alt"></span><em>45&deg;</em>
              </span>
            </button>
          </div>
          <!-- 
          <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.scaleX(-1)">
                <span class="fa fa-arrows-alt-h"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.scaleY(-1)">
                <span class="fa fa-arrows-alt-v"></span>
              </span>
            </button>
          </div> -->

          <!-- <div class="btn-group">
            <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.crop()">
                <span class="fa fa-check"></span>
              </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="cropper.clear()">
                <span class="fa fa-times"></span>
              </span>
            </button>
          </div> -->


        </div>
        <!-- 
        <div class="docs-toggles">
          <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
            <label class="btn btn-primary active">
              <input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.7777777777777777">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="aspectRatio: 16 / 9">
                16:9
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1.3333333333333333">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="aspectRatio: 4 / 3">
                4:3
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="aspectRatio: 1 / 1">
                1:1
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="0.6666666666666666">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="aspectRatio: 2 / 3">
                2:3
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="aspectRatio5" name="aspectRatio" value="NaN">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="aspectRatio: NaN">
                Free
              </span>
            </label>
          </div>

          <div class="btn-group d-flex flex-nowrap" data-toggle="buttons">
            <label class="btn btn-primary active">
              <input type="radio" class="sr-only" id="viewMode0" name="viewMode" value="0" checked="">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="View Mode 0">
                VM0
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="viewMode1" name="viewMode" value="1">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="View Mode 1">
                VM1
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="viewMode2" name="viewMode" value="2">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="View Mode 2">
                VM2
              </span>
            </label>
            <label class="btn btn-primary">
              <input type="radio" class="sr-only" id="viewMode3" name="viewMode" value="3">
              <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="View Mode 3">
                VM3
              </span>
            </label>
          </div>
        </div> -->
        <div class="docs-data">
          <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="objGroup">Object Group</label>
            </span>
            <select class="form-control" id="objGroup" placeholder="Object Group">
              <?php
              $objgroups_select = "SELECT * from object_groups";
              $objgroups_result = $conn->query($objgroups_select);
              while ($row = $objgroups_result->fetch_assoc()) {
                echo "<option value='" . $row['OBJECT_GROUP_ID'] . "'>" . $row['OBJECT_GROUP_NAME_EN'] . "</option>";
              }
              ?>
            </select>
          </div>

          <div class="input-group input-group-sm">
            <span class="input-group-prepend">
              <label class="input-group-text" for="objName">Object Name</label>
            </span>
            <input type="text" class="form-control" id="objName" placeholder="Object Name" style="margin-left:0px;">
          </div>


        </div>
        <div class="docs-buttons">
          <button type="button" class="btn btn-primary" title="Save" id="saveBtn" data-method="getCroppedCanvas">
            <span class="docs-tooltip" data-toggle="tooltip" title="" data-original-title="Save">
              Save
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>

  </div>
</body>

</html>