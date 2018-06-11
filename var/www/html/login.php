<?php
	require "config.php";
	session_start();

	if(isset($_SESSION['user'])) {
		header("location: index.php");
		die();
	}

	$msg = "";
	if(isset($_POST['username']) && isset($_POST['password'])) {
		if($_POST['username'] != $config['controlPanelLogin']['username'] || $_POST['password'] != $config['controlPanelLogin']['password']) {
			$msg = "<div class='error'>Username or password is incorrect (We're guessing it's the password).</div>";
		} else {
			$msg = "<div class='success'>Login successful.</div>";
			$_SESSION['user'] = $_POST['username'];
			header("location: index.php");
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="style.css">
		<title>CraftBox</title>
	</head>
	<body>
		<header>
			<div class="top">
				<div class="logo"><h1>CraftBox</h1></div>
			</div>
		</header>
		<main>
			<div class="login-container">
				<form method="post">
					<div class="container">
						<label for="uname"><b>Username</b></label>
						<input type="text" placeholder="" name="username" required>

						<label for="psw"><b>Password</b></label>
						<input type="password" placeholder="" name="password" required>

						<button type="submit">Log in</button>
						<?php echo $msg; ?>
					</div>
				</form>
			</div>
		</main>
	</body>
</html>
