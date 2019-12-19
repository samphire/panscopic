<?php
//session_start();

error_reporting(1);
date_default_timezone_set('Asia/Seoul');
global $conn;
$conn = mysqli_connect("localhost", "root", "Fk!i=a0@:K", "panscopic") or die('Error connecting to mysql in sessionheader.inc');
//mysql_select_db("panscopic", $link1);
mysqli_query($conn, "SET NAMES utf8");
mysqli_query($conn, "SET CHARACTER SET utf8");
session_cache_limiter('private_no_expire, must-revalidate');
$_SESSION['global_url'] = "http://www.notborder.org/scopic";
//$_SESSION['global_url'] = "http://localhost/scopic";