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
} else{
    echo('fail');
}


