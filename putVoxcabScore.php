<?php
include("sessionheader.inc");

if (($_POST)['score'] > 99) $_POST['num_perfect'] += 1;
if (($_POST['score'] < 100) and $_POST['num_perfect'] > 0) $_POST['num_perfect'] -= 1;

$delete = false;

switch ($_POST['num_perfect']) {
    case 1:
        $interval = "0 1:00:0";
        break;
    case 2:
        $interval = "1 0:00:0";
        break;
    case 3:
        $interval = "5 0:00:0";
        break;
    case 4:
        $interval = "27 0:00:0";
        break;
    case 5:
        $delete = true;
        break;
    default:
        $interval = "0";
}

if ($delete) {
    $sql = "DELETE from panscopic.tbl_student_voxcab where id=" . $_POST['testid'];
} else {
    $sql = "UPDATE panscopic.tbl_student_voxcab set score=" . $_POST['score'] . ", start_date = ADDTIME(NOW(), '" . $interval . "'),
        end_date = DATE_ADD(NOW(), INTERVAL 3 month), num_perfect = " . $_POST['num_perfect'] . ", time=" . $_POST['time'] . "
        where id=" . $_POST['testid'];
}
//echo $sql;

$query = mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {

    if($delete){
        echo "delete";
    } else{
        $sql = "select start_date from panscopic.tbl_student_voxcab where id = " . $_POST['testid'];
        $query = mysqli_query($conn, $sql);
        $value = $query->fetch_object();
        $datetime = new DateTime($value->start_date);
        echo $datetime->format(DateTime::ATOM); // Updated ISO8601
    }
} else {
    echo('fail');
}