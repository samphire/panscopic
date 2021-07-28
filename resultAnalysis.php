<?php
include("sessionheader.inc");
$testid = $_GET['testid'];

$sql = "SELECT fld_qnstable from tbl_tests where fld_test_id=$testid";

$tablenum = mysqli_query($conn, $sql)->fetch_object()->fld_qnstable;
$qtable = "tbl_qns" . $tablenum;
$rtable = "tbl_response" . $tablenum;

$sql = "select $qtable.fld_qnum, count from $qtable LEFT JOIN
(SELECT fld_question_id as qnum, count(fld_student_id) as count from
(SELECT * from $qtable LEFT JOIN
(SELECT fld_student_id, fld_question_id FROM $qtable JOIN $rtable on $rtable.fld_question_id=$qtable.fld_qnum where fld_response=fld_answer) AS bob
ON $qtable.fld_qnum = bob.fld_question_id) AS sid
group by fld_question_id order by qnum) as roger
on $qtable.fld_qnum = roger.qnum
order by count, fld_qnum";

$json = array();
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_row($result)) {
    $jsonRow = json_encode($row);
    array_push($json, $row);
}
echo json_encode($json);