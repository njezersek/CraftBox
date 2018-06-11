<?php
session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}
if(isset($_GET["world"])){
  $path = zipdir($_GET["world"]);
  if($path == "error")die();


  if (file_exists($path)){
      $contents = file_get_contents($path);
      $type = mime_content_type($path);
      $name = pathinfo($path, PATHINFO_BASENAME);
      header('Content-type: '.$type.'');
      header('Content-Disposition: attachment; filename="'.$name.'"');

      echo $contents;
  }
}


function zipdir($worldName){
  $dest = "/var/www/html/worlds";
  $worldsFolder = "/home/minecraft/saves";

	class FlxZipArchive extends ZipArchive {
		public function addDir($location, $name) {
			$this->addEmptyDir($name);
			$this->addDirDo($location, $name);
		}
		private function addDirDo($location, $name) {
			$name .= '/';
			$location .= '/';
			$dir = opendir ($location);
			while ($file = readdir($dir))    {
				if ($file == '.' || $file == '..') continue;
				$do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
				$this->$do($location . $file, $name . $file);
			}
		}
	}

  $za = new FlxZipArchive;
  if($za->open($dest.'/'.$worldName.".zip", ZipArchive::CREATE) === TRUE)    {
    $za->addDir($worldsFolder."/".$worldName, $worldName);
    $za->addDir($worldsFolder."/".$worldName."_nether", $worldName."_nether");
    $za->addDir($worldsFolder."/".$worldName."_the_end", $worldName."_the_end");
    $za->close();
    return $dest.'/'.$worldName.".zip";
  }
  else {
    return "error";
  }

}
?>
