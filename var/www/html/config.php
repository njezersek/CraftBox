<?php
  $config_path = "/var/www/config.json";
  $config_json_text = file_get_contents($config_path);
  $config = json_decode($config_json_text, true);
?>
