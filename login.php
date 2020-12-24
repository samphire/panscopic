<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");
$student = $_GET['studentid'];

$sql = "SELECT fld_name FROM tbl_students WHERE fld_student_id='" . $student."'";
$query = mysqli_query($conn, $sql) OR die("something wrong happened\n" . $sql);
list($name) = mysqli_fetch_row($query);

$_SESSION['studid'] = $student;
$_SESSION['studname'] = $name;