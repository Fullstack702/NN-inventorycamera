var SELECTED_IMAGE_ID = 0;
var IMAGE_LIST_URL = "./list_images.php";
var SHOW_IGNORED = 0;
var SHOW_TO_ANNOTATE = 1;
var SHOW_ANALYZED = 0;
var SHOW_START = 0;
var SHOW_END = 1000;

function set_show_ignored(value) {
  SHOW_IGNORED = value;
}

function set_show_analyzed(value) {
  SHOW_ANALYZED = value;
}

function set_show_to_annotate(value) {
  SHOW_TO_ANNOTATE = value;
}

function show_image_list() {
  //$( "#img_fn_list" ).append( "<p>Test</p>" );
  query_url =
    IMAGE_LIST_URL +
    "?start=" +
    SHOW_START +
    "&end=" +
    SHOW_END +
    "&analyzed=" +
    SHOW_ANALYZED +
    "&ignored=" +
    SHOW_IGNORED +
    "&to_annotate=" +
    SHOW_TO_ANNOTATE;

  var client_id = $('#via_client_selector').val();
  var camera_id = $('#via_camera_selector').val();

  if (client_id > 0)
    query_url = query_url + "&client_id=" + client_id;
  if (camera_id > 0)
    query_url = query_url + "&camera_id=" + camera_id;

  //console.log("list query: "+query_url);
  $.get(query_url, function (data, status) {
    //alert("Data: " + data + "\nStatus: " + status);
    $("#image_list").html(data);
  });
}

function set_ignore_flag(image_id, change_to) {
  console.log("ignore image: " + image_id + " to: " + change_to);
  set_url =
    IMAGE_LIST_URL +
    "?set_ignore_id=" +
    image_id +
    "&set_ignore_to=" +
    change_to;
  $.get(set_url);
  show_image_list();
  console.log("list should be loaded: ");
}

function select_image(pic_id) {
  //console.log("image path: "+img_path);
  //	this._project_load_on_local_file_read(alexis_data);

  //project_remove_file(0);
  //project_file_add_url(img_path);
  //_via_clear_reg_canvas();
  //_via_show_img(0);
  var via_obj = this.via;
  // var span_obj = document.getElementById('image_id_label');
  // var strong = document.createElement('strong');
  // span_obj.innerHTML = "12312313";
  // console.log(span_obj)
  var uri = "./get_project.php" + "?&pic_id=" + pic_id;
  $.get(uri, function (data, status) {
    via_obj.d.project_load(data);
    _via_util_page_hide();
    document.getElementById('image_id_label').innerText = pic_id; 
  });
}

$(".image_browser_menu_item").on("change", function () {
  //console.log("id of change: "+this.id+" status: "+$(this).prop("checked"));
  switch (this.id) {
    case "show_ignored_checkbox":
      set_show_ignored(Number($(this).prop("checked")));
      show_image_list();
      break;
    case "show_analyzed_checkbox":
      set_show_analyzed(Number($(this).prop("checked")));
      show_image_list();
      break;
    case "show_to_annotate_checkbox":
      set_show_to_annotate(Number($(this).prop("checked")));
      show_image_list();
      break;
  }
});

function set_ignore() {
  var file_obj = this.via.d.store.file[Object.keys(this.via.d.store.file)[0]];
  if (file_obj) {
    pic_id = file_obj.pic_id;
    set_ignore_flag(pic_id, 1)
  }
}

function set_navigate_image(direction) {

  if (!this.via)
    return;
  
  var file_obj = this.via.d.store.file[Object.keys(this.via.d.store.file)[0]];

  if (!file_obj) return;
  pic_id = file_obj.pic_id;
  camera_id = $("#via_camera_selector").val();

  var uri = "./get_project.php" + "?&pic_id=" + pic_id + "&analyzed=" +
    SHOW_ANALYZED + "&ignored=" + SHOW_IGNORED + "&to_annotate=" + SHOW_TO_ANNOTATE + '&direction=' + direction + '&camera_id='+ camera_id;

  var via_obj = this.via;

  $.get(uri, function (data, status) {
    via_obj.d.project_load(data);
    _via_util_page_hide();
    var data_json = JSON.parse(data);
    var file_obj = data_json.file[Object.keys(data_json.file)[0]];
    document.getElementById('image_id_label').innerText = file_obj.pic_id;     

  });
}

function create_objects(pic_id){
  window.open("/ui/create_objects/?pic_id="+pic_id, '_blank');
  
}