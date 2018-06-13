<?php
function arr2yml(array $a) {
	$out = '';
	foreach ($a as $k => $v) {
		$out .= "$k: $v" . PHP_EOL;
	}
	return $out;
}

	function arr2ini(array $a) {
		$out = '';
		foreach ($a as $k => $v) {
			$out .= "$k=$v" . PHP_EOL;
		}
		return $out;
	}

	function ini2arr($s) {
		$returnArray = array();
		$settings = explode("\n", $s);
		foreach ($settings as $key => $value) {
			$setting = explode("=", $value );
			if(strlen($setting[0]) == 0) continue;
			if(count($setting) == 1) {
				$returnArray[$setting[0]] = '';
			}
			else if(count($setting) == 2) {
				$returnArray[$setting[0]] = $setting[1];
			}
			else if(count($setting) > 2) {
				$implodeBack = array();
				$firstLoop = true;
				foreach($setting as $tmpValue) {
					if($firstLoop) {
						$firstLoop = false;
					}
					else {
						$implodeBack[] = $tmpValue;
					}
				}
				$returnArray[$setting[0]] = implode('=', $implodeBack);
			}
		}

		return $returnArray;
	}

	function startsWith($haystack, $needle) {
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

	function endsWith($haystack, $needle){
		$length = strlen($needle);
		return $length === 0 || (substr($haystack, -$length) === $needle);
	}

	function restartMinecraft(){
		$running = shell_exec("ps aux | grep spigot.jar | grep -v grep | grep -v SCREEN");
		if(empty($running)) {
			exec("sudo -u pi /home/minecraft/scripts/minecraft.sh start");
		} else {
			do {
				exec("sudo -u pi /home/minecraft/scripts/minecraft.sh stop");
				$running = shell_exec("ps aux | grep spigot.jar | grep -v grep | grep -v SCREEN");
				} while (empty($running) != true);
				exec("sudo -u pi /home/minecraft/scripts/minecraft.sh start");
			}
		}

	function reboot(){
		shell_exec("sudo reboot");
	}

	function reconCommand($command){
		require 'rcon/rcon-backend.php';
		require 'rcon/minecraft_string.php';

		$server = 'localhost';
		$port = 25575;
		$password = 'craftbox';

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
		return $return;
	}
?>
