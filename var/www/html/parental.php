<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "functions.php";

session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}

$currentConfig = file_get_contents('/home/spigot/plugins/TimeRestriction/config.yml');
$config = yaml_parse($currentConfig);

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
    $config['start'] = date('H:i', strtotime($start));
    $config['end'] = date('H:i', strtotime($end));
    $config['enabled'] = $enabled;

		//var_dump($config);

    $newConfig =
'enabled: '.$config['enabled'].'
start: "'.$config['start'].'"
end: "'.$config['end'].'"';
    file_put_contents('/home/spigot/plugins/TimeRestriction/config.yml', $newConfig);

		rconCommand('reload');

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
		        <input type="checkbox" <?php if($config['enabled'] == "true")echo "checked";?> onchange="document.getElementById('enable_time_restriction').value = this.checked+''">
		        <span class="slider round"></span>
		        </label>
		        <input type="hidden" name="enable_time_restriction" id="enable_time_restriction" value="<?php if($config['enabled'])echo "true";else echo "false"; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Restrict access from</label>
					</div>
					<div class="input-container">
						<input type="text" name="start" value="<?php echo $config['start']; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">until</label>
					</div>
					<div class="input-container">
						<input type="text" name="end" value="<?php echo $config['end']; ?>">
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
