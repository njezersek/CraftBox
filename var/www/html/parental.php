<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}

require "config.php";

$msg = "";

if(isset($_POST['start']) && isset($_POST['end']) && isset($_POST['enable_time_restriction'])){
  $ok = true;
  $start = $_POST['start'];
  $end = $_POST['end'];
  $enabled = $_POST['enable_time_restriction'];

  if(strtotime($start) == false || strtotime($end) == false){
    $ok = false;
    $msg .= "<div class='error'>Time must be written in <i>hh:mm</i> format!</div>";
  }

  if($ok){
    $config['timeRestriction']['start'] = $start;
    $config['timeRestriction']['end'] = $end;
    $config['timeRestriction']['enabled'] = $enabled;

    $newJson = json_encode($config);
    file_put_contents('/var/www/config.json', $newJson);

    $msg = "<div class='success'>Time restriction settings were updated.</div>";
  }
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
      <?php echo $msg; ?>
      <h2>Time restriction</h2>
      <form action="parental.php" method="post">
				<div class="option-container">
					<div class="info-container">
						<label class="property">Enable time restriction</label>
					</div>
					<div class="input-container">
						<label class="switch">
		        <input type="checkbox" <?php if($config['timeRestriction']['enabled'] == "true")echo "checked";?> onchange="document.getElementById('enable_time_restriction').value = this.checked+''">
		        <span class="slider round"></span>
		        </label>
		        <input type="hidden" name="enable_time_restriction" id="enable_time_restriction" value="<?php echo $config['timeRestriction']['enabled']; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Restrict access from</label>
					</div>
					<div class="input-container">
						<input type="text" name="start" value="<?php echo $config['timeRestriction']['start']; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">until</label>
					</div>
					<div class="input-container">
						<input type="text" name="end" value="<?php echo $config['timeRestriction']['end']; ?>">
					</div>
				</div>
				<br>
        <div class="help">Time shall be writen in <i>hh:mm</i> format.</div>
				<br>
        <input type="submit" value="Save" class="button">
      </form>
    </div>
  </main>
</body>
</html>
