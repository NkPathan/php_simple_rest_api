<?php
$db_server = "localhost";
$db_user = "root";
$db_pass = "password";
$db_name = "php_rest_api";

$conn = new mysqli($db_server,$db_user,$db_pass,$db_name);

// Check connection
if ($conn -> connect_errno) {
  echo "Failed to connect to MySQL: " . $conn -> connect_error;
  die();
}
?>