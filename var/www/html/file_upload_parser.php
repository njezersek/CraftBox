<?php
$fileName = $_FILES["file1"]["name"]; // File name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 = false, 1 = true
if (!$fileTmpLoc) { // if file not chosen
    echo "<div class='error'>Error. Could not upload the file.</div>";
    exit();
}
if(strtolower($fileType) != "application/x-zip-compressed"){
  echo "<div class='error'>Error. This is not a zip file!</div>".$fileType;
  exit();
}
if(unzipdir($fileTmpLoc)){
    echo "<div class='success'>$fileName upload is complete.</div>";
} else {
    echo "<div class='error'>Could not move $fileName to server.</div>";
}

function unzipdir($path){
	$zip = new ZipArchive;
  $dest = "/home/spigot/saves";

  if ($zip->open($path) === TRUE) {
      if(!$zip->extractTo($dest)){
        return false;
      }
      $zip->close();

	    return true;
  }
  else {
      return false;
  }
}
?>
