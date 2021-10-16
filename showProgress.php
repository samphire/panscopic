<?php
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type");
header('Content-Type: text/plain');
$myConn = mysqli_connect("localhost", "root", "Fk!i=a0@:K") or die('Error making custom mysqli connection' . mysqli_connect_error());
$sql="drop table if exists panscopic.BOB";
$result = mysqli_query($myConn, $sql) or die("1".mysqli_error($myConn));
$sql="create temporary table panscopic.BOB SELECT id, name, round(cash_earned/60) AS MathPerc FROM panscopic.tbl_user join panscopic.tbl_stud_class on tbl_user.id = tbl_stud_class.fld_student_id where tbl_stud_class.fld_class_id={$_GET['classid']};";
$result = mysqli_query($myConn, $sql) or die("2".mysqli_error($myConn));
$sql="drop table if exists panscopic.duck";
$result = mysqli_query($myConn, $sql) or die("3".mysqli_error($myConn));
$sql="create temporary table panscopic.duck SELECT user_email, goalwords FROM reader3.users;";
$result = mysqli_query($myConn, $sql) or die("4".mysqli_error($myConn));
$sql="select * from panscopic.duck";
$result = mysqli_query($myConn, $sql) or die("5".mysqli_error($myConn));
$sql="drop table if exists panscopic.carvery";
$result = mysqli_query($myConn, $sql) or die("6".mysqli_error($myConn));
$sql="
create temporary table panscopic.carvery 
select user_email, numLearned, numLearning, avgRepnum from 
reader3.users left join
(SELECT oboe.userid, numLearned, numLearning, avgRepnum from
(SELECT amy.userid, numLearned, numLearning from
(SELECT userid, COUNT(headwordid) AS numLearned FROM reader3.learned group by userid) as amy
left join
(SELECT userid, COUNT(repnum) AS numLearning FROM reader3.learninglist group by userid) as glob
on amy.userid = glob.userid) as tim left join
(SELECT userid, AVG(repnum) AS avgRepnum FROM reader3.learninglist group by userid) as oboe
on tim.userid = oboe.userid
) as grey
on users.user_id=grey.userid;
";
$result = mysqli_query($myConn, $sql) or die("7".mysqli_error($myConn));

$sql="SELECT tommy.*, fld_class_id AS classid from
(select  user_email AS id, name, numLearned, numLearning, avgRepnum, MathPerc, numLearned + round(numLearning * avgRepnum * 0.1) as wordscore from 
panscopic.carvery left join (SELECT BOB.*, duck.goalwords  from panscopic.BOB left join panscopic.duck on BOB.id = duck.user_email) as wowbob on carvery.user_email = wowbob.id) as tommy
join panscopic.tbl_stud_class on tommy.id=panscopic.tbl_stud_class.fld_student_id
where fld_class_id={$_GET['classid']} order by id;";
$result = mysqli_query($myConn, $sql) or die("8".mysqli_error($myConn));

$array = Array();
while($row = mysqli_fetch_assoc($result)){
    array_push($array,$row);
}
echo json_encode($array);