<?php
/**
 * Created by IntelliJ IDEA.
 * User: matthew
 * Date: 2/16/2016
 * Time: 10:20 PM
 */
include("sessionheader.inc");
$sql = "SELECT * FROM tbl_students WHERE fld_student_id = '" . $_GET['user'] . "' AND fld_pass = '" . $_GET['password'] . "';";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
    echo('success');
    $sql = "SELECT fld_name FROM tbl_students WHERE fld_student_id='" . $_GET['user']."'";
    $query = mysqli_query($conn, $sql) OR die("something wrong happened\n" . $sql);
    list($name) = mysqli_fetch_row($query);

    $_SESSION['studid'] = $_GET['user'];
    $_SESSION['studname'] = $name;
} else{
    echo('fail');
}


