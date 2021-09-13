<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");
//error_log("testing", 1, "555pontifex@naver.com");
//error_log("testing", 1, "boak67@gmail.com");
error_log("testing", 0);
//print("two: <h5>student: ".$_POST['studid'].", response table ".$_POST['qnstable']."</h5>");
if($_POST['prof']){
    
    $sql="delete from tbl_response".$_POST['qnstable']." where fld_student_id='".$_POST['studid']."'";
    mysqli_query($conn,$sql);
    $sql="delete from tbl_stud_testscore where fld_student_id='".$_POST['studid']."'";
    mysqli_query($conn,$sql);
    
}
?>
    <style type="text/css">
        #again {
            position: absolute;
            left: 28%;
            top: 30%;
            font-family: 'ubunturegular', Arial, sans-serif;
            font-size: 3em;
            text-align: center;
            background-color: #333333;
            color: yellowgreen;
            border-radius: 5px;
            width: 40%;
            padding: 2%;
        }

        #btnAgain {
            margin: 1rem;
            width: 240px;
            height: 105px;
            text-align: right;
            font-size: 0.7em;
        }

        input {
            padding: 3%;
            font-size: 0.5em;
            border-radius: 8px;
        }

        #home {
            position: fixed;
            left: 0px;
            top: 0px;
            height: 100%;
            cursor: pointer;
        }

        @media screen and (max-width: 760px) {
            #again {
                left: 3%;
                width: 90%;
            }

            body {
                padding-left: 0%;
                margin-left: 0%;
            }
        }

    </style>

    <script type="text/javascript">
        function goHome() {
            window.location.href = "home.php";
        }

        imgArr = ['meme.png', 'fem.png', 'rog.png', 'fees.png', 'jimmy.png', 'root.png', 'angry kitty.png', 'kitty.png', 'anger.png', 'monkey.png', 'soldier.png', 'guy.png', 'moon.png', 'bird.png', 'symbol.png'];


        window.onload = function () {
            indx = Math.floor(Math.random() * imgArr.length);
            var randomImage = "url('img/" + imgArr[indx] + "')";
            var el = document.getElementById("btnAgain");
            if (el != null) {
                el.style.background = "azure " + randomImage + " no-repeat";
                el.value = "Again";
            }
        }
    </script>

<?php
print "\n</head>";
print "<div id='home' onclick='goHome()'><img src='home.png'></div>";
//Select Wrongly Answered Questions Function
function callWrong($con)
{
    $sql = "SELECT * FROM tbl_qns" . $_POST['qnstable'] . "
        INNER JOIN tbl_response" . $_POST['qnstable'] . "
        ON tbl_qns" . $_POST['qnstable'] . ".fld_qnum = tbl_response" . $_POST['qnstable'] . ".fld_question_id
        WHERE tbl_response" . $_POST['qnstable'] . ".fld_response <> BINARY tbl_qns" . $_POST['qnstable'] . ".fld_answer
        AND tbl_response" . $_POST['qnstable'] . ".fld_student_id='" . $_POST['studid'] . "'
        ORDER BY tbl_qns" . $_POST['qnstable'] . ".fld_qnum";

//    echo "<br>$sql<br>";
    error_log("callWrong\n".$_POST['studid'].": ".$sql, 0);

    $query = mysqli_query($con, $sql);

    if (!$query) {
        die("<br><br>oops! " . mysqli_error($con));
    }
    return $query;
}

//function calcScore($query)
function calcScore($numWrong)
{
    $percent_score = round(($_POST['numq'] - $numWrong) / $_POST['numq'] * 100);
    return $percent_score;
}

function trimbo($stringo)
{
    //Trims single quotes, then whitespace, then reinserts single quotes
//    $tempo = trim($stringo, chr(39));
//    $tempo = trim($tempo);
//    $tempo = chr(39) . $tempo . chr(39);
    $tempo = mysqli_real_escape_string($conn, $stringo);


    return $tempo;
}

//format responses
for ($x = 1; $x <= $_POST['numq']; $x++) {
    $response[$x] = $_POST["response$x"];
}

if ($_POST['retain'] == -1) {

//    echo "retain<br>";

    //check to see if data exists. If exists, update, else insert  
    $sql = "SELECT * FROM tbl_response" . $_POST['qnstable'] . " WHERE fld_student_id='" . $_POST['studid'] . "'";
    error_log("check data exist\n".$_POST['studid'].": ".$sql, 0);
    $query = mysqli_query($conn, $sql) or die("Query is failing early  " . mysqli_error($conn));
    $data = mysqli_fetch_array($query);

    if ($data) {

//        echo "data<br>";
        //If not callWrong, the update query below will replace all values in tbl_reponse!!!
        $query = callWrong($conn);
        //UPDATE response table
        $sql = "Update tbl_response" . $_POST['qnstable'] . "
        SET tbl_response" . $_POST['qnstable'] . ".fld_response = CASE tbl_response" . $_POST['qnstable'] . ".fld_question_id ";
        while (list($qnumber, , $txt1, , , , , , , $answer) = mysqli_fetch_row($query)) {
            $sql .= " WHEN $qnumber THEN '" . mysqli_real_escape_string($conn, $response[$qnumber]) . "'";
        }
        $sql .= " ELSE tbl_response" . $_POST['qnstable'] . ".fld_response END
        WHERE fld_student_id='" . $_POST['studid'] . "'";

//        echo $sql . "<br>";
        error_log("There is Data, so update\n".$_POST['studid'].": ".$sql, 0);
        mysqli_query($conn, $sql) or die("Error message is:  " . mysqli_error($conn));

//        //SELECT wrongly answered questions
//        $query = callWrong($conn);
        //CALCULATE score
        $percent_score = calcScore(mysqli_num_rows($query));
        //UPDATE scores table
        $sql = "UPDATE tbl_stud_testscore SET fld_score = $percent_score WHERE fld_student_id='" . $_POST['studid'] . "' AND fld_test_id=" . $_POST['testid'];
        error_log("update scores table\n".$_POST['studid'].": ".$sql, 0);
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    } else {

//        echo "no data<br>";
        // INSERT response table     This should not work because of shuffle... something fishy going on that makes it work, but is it reliable?
        $sql = "INSERT INTO tbl_response" . $_POST['qnstable'] . " (fld_student_id,fld_question_id,fld_response) VALUES";
        for ($x = 1; $x <= $_POST['numq']; $x++) {
            $sql .= "('" . $_POST['studid'] . "',$x,'" . mysqli_real_escape_string($conn, $response[$x]) . "'),";
        }
        $sql = rtrim($sql, ",");
        error_log("no previous data\n".$_POST['studid'].": ".$sql, 0);
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

        //SELECT wrongly answered questions
        $query = callWrong($conn);
        //CALCULATE score
//        $percent_score = calcScore($query);
        $percent_score = calcScore(mysqli_num_rows($query));
        //INSERT scores table
        $sql = "INSERT INTO tbl_stud_testscore(fld_student_id, fld_test_id, fld_score) VALUES('" . $_POST['studid'] . "', " . $_POST['testid'] . ",$percent_score)";
        error_log("there was no previous data\n".$_POST['studid'].": ".$sql, 0);
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
    }
} else {

//    echo "deleting responses";
    $sql = "DELETE FROM tbl_response" . $_POST['qnstable'] .
        " WHERE tbl_response" . $_POST['qnstable'] . ".fld_student_id='" . $_POST['studid'] . "'";
    error_log("deleting responses\n".$_POST['studid'].": ".$sql, 0);
    mysqli_query($conn, $sql);

//    echo "deleting scores";
    $sql = "DELETE FROM tbl_stud_testscore
        WHERE fld_student_id='" . $_POST['studid'] . "'
        AND fld_test_id='" . $_POST['testid'] . "'";
    error_log("deleting scores\n".$_POST['studid'].": ".$sql, 0);
    mysqli_query($conn, $sql);

    $sql = "INSERT INTO tbl_response" . $_POST['qnstable'] . " (fld_student_id,fld_question_id,fld_response) VALUES";
    for ($x = 1; $x <= $_POST['numq']; $x++) {
        $sql .= "('" . $_POST['studid'] . "',$x,'" . mysqli_real_escape_string($conn, $response[$x]) . "'),";
    }
    $sql = rtrim($sql, ",");
    error_log("insert to response table\n".$_POST['studid'].": ".$sql, 0);
    mysqli_query($conn, $sql) or die("damn!" . mysqli_error($conn) . "<br><br>" . $sql);

    //SELECT wrongly answered questions
    $query = callWrong($conn);
    //CALCULATE score
//    $percent_score = calcScore($query);
    $percent_score = calcScore(mysqli_num_rows($query));
    //INSERT scores table
    $sql = "insert into tbl_stud_testscore(fld_student_id, fld_test_id, fld_score) VALUES('" . $_POST['studid'] . "', '" . $_POST['testid'] . "',$percent_score)";
    error_log("inserting score\n".$_POST['studid'].": ".$sql, 0);
    mysqli_query($conn, $sql) or die("woah!" . mysqli_error($conn));
}

$percent_score = round($percent_score);
if ($_POST['retain'] == -1) {
    if ($percent_score != 100) {
        $bob = $_POST['testid'] . "/" . $_SESSION['testblurb'];

        print "<div id='again'>\n$percent_score%
    <form action='" . $_SESSION['global_url'] . "/test.php' method='get'>\n
    <input type='submit' id='btnAgain' value='' />\n
	<input type='hidden' name='testid' value='".$_POST['testid']."'>
	<input type='hidden' name='studid' value='".$_POST['studid']."'>
    </form>\n</div>";
    } else {
        print "<div id='again'>만점</div>";
    }
} else {
    print "<div id='again'>\n$percent_score%</div>";
}
print "\n</div>\n</body>\n</html>";
exit();
?>