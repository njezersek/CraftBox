<?php
	require 'rcon/rcon-backend.php';
	require 'rcon/minecraft_string.php';

	session_start();
	if(!isset($_SESSION['user'])){
		if(isset($_GET['rcon']))die("Session expired. Refresh the page and log in again.");
		header("location: login.php");
		die();
	}

	$server = 'localhost';
	$port = 25575;
	$password = 'craftbox';

	$command = isset($_GET['rcon']) && !empty($_GET['rcon']) ? $_GET['rcon'] : 'version';

	if ($command[0] == '/') {
		$command = substr($command, 1);
	}

	try
	{
		$rcon = new RCon($server, $port, $password);
		$return =  nl2br(minecraft_string($rcon->command($command)));
	}
	catch(Exception $e)
	{
		$return = $e->getMessage( );
	}
	if (isset($_GET['rcon'])) die($return);

?>

<!doctype html>
<html>
	<head>
		<?php include "frame/head.php"; ?>
	</head>
	<body>
		<?php include "frame/header.php"; ?>
		<main class="console-main" id="main">
			<div class="max">
				<div class="rcon">
					<div id="console">
						<?php echo $return ?>
					</div>
					<input type="text" id="input">
				</div>
			</div>
		</main>
		<script src="rcon/jquery.min.js"></script>
		<script src="rcon/jquery.inputhistory.js"></script>
		<script>
			$('input').focus().inputHistory(function(value){
				$('#console').html($('#console').html() + '<br><strong>&gt; ' + value + '</strong>');
				$.get('?rcon=' + encodeURIComponent(value), function(data){
					$('#console').html($('#console').html() + '<br>' + data);
					$('#main').animate({ scrollTop: $('#main')[0].scrollHeight}, 800);
				});
			});
		</script>
	</body>
</html>
