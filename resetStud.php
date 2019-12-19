<?php

include("sessionheader.inc");

$sql = "DELETE FROM tbl_stud_testscore WHERE fld_student_id = '". $_GET['stud'] . "' AND fld_test_id = " . $_GET['test'];
$query = mysqli_query($conn, $sql);

$sql = "SELECT * FROM tbl_tests WHERE fld_test_id='" . $_GET['test'] . "'";
$query = mysqli_query($conn, $sql);
list(,,,,,,,,,,,,,,$qtable) = mysqli_fetch_row($query);
$sql = "DELETE FROM tbl_response" . $qtable . " WHERE fld_student_id = '". $_GET['stud'] . "'";
$query = mysqli_query($conn, $sql);
//$retval = mysqli_affected_rows($conn);
//if ($retval > 0) {
//echo('success');
//} elseif ($retval < 0){
//echo('fail');
//}


