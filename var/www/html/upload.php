<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include "frame/head.php"; ?>
</head>
<body>
  <?php include "frame/header.php"; ?>
  <main>
    <div class="max">
			<a href="worlds.php" class="back"><img src="res/back.png" width="32px">Back to World configuration</a>
      <h2>Upload world</h2>
      <div id="drop_zone" ondrop="drag_drop(event)" ondragover="return false">
        <div class="info-container">
          <div>Drag and drop zip file of the world here.</div>
          <div class="line-container">
            <div class="line"></div>
            <div class="text">or</div>
            <div class="line"></div>
          </div>
          <div class="button" onclick="chooseFile()">Choose a file</div>
        </div>
      </div>
      <form id="upload_form" enctype="multipart/form-data" method="post">
        <input type="file" name="file1" id="file1" onchange="uploadFile()" style="display:none"><br>
				<div class="progressbar-container">
					<div class="progressbar" style="width: 0%" id="progressBar">
					</div>
				</div>
        <h3 id="status"></h3>
        <p id="loaded_n_total"></p>
      </form>
    </div>
  </main>

  <script>
  function _(el){
    return document.getElementById(el);
  }
  function uploadFile(){
  var file = _("file1").files[0];
  var formdata = new FormData();
  formdata.append("file1", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "file_upload_parser.php");
  ajax.send(formdata);
  }
  function upload(file){
  var formdata = new FormData();
  formdata.append("file1", file);
  var ajax = new XMLHttpRequest();
  ajax.upload.addEventListener("progress", progressHandler, false);
  ajax.addEventListener("load", completeHandler, false);
  ajax.addEventListener("error", errorHandler, false);
  ajax.addEventListener("abort", abortHandler, false);
  ajax.open("POST", "file_upload_parser.php");
  ajax.send(formdata);
  }
  function drag_drop(event) {
    event.preventDefault();
  upload(event.dataTransfer.files[0]);
  }
  function progressHandler(event){
  _("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
  var percent = (event.loaded / event.total) * 100;
  _("progressBar").style.width = Math.round(percent)+"%";
  _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
  }
  function completeHandler(event){
  _("status").innerHTML = event.target.responseText;
  _("progressBar").style.width = "0";
  }
  function errorHandler(event){
  _("status").innerHTML = "Upload Failed";
  }
  function abortHandler(event){
  _("status").innerHTML = "Upload Aborted";
  }

  function chooseFile(){
    _("file1").click();
  }
  </script>
</body>
</html>
