<?php
/**
 * Created by IntelliJ IDEA.
 * User: matthew
 * Date: 2/16/2016
 * Time: 9:04 PM
 */
include("sessionheader.inc");
$sql = "UPDATE tbl_students SET fld_pass='" . $_GET['password'] . "' WHERE fld_student_id = '" . $_GET['user'] . "'";
$query = mysqli_query($conn, $sql);
$retval = mysqli_affected_rows($conn);
if ($retval > 0) {
    echo('success');
} elseif ($retval < 0){
    echo($sql);
}


