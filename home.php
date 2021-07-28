<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");

function convert_datetime($str)
{
    list($date, $time) = explode(' ', $str);
    list($year, $month, $day) = explode('-', $date);
    list($hour, $minute, $second) = explode(':', $time);
    return mktime($hour, $minute, $second, $month, $day, $year);

}

?>
    <style>
        body {
            background-color: #ECDFCD;
            font-size: x-large;
            font-family: 'ubunturegular', Arial, sans-serif;
        }

        #stars {
            width: 90%;
            margin: 0 auto;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #54B77E;
            padding: 2%;
            text-align: center;
        }

        .stardiv {
            margin: auto;
            float: left;
            width: 20%;
        }

        .header {
            text-align: center;
        }

        .testChoice {
            border-radius: 5px;
            /*background-color: #333333;*/
            background-color: #6AD9D9;
            padding: 2%;
            width: 90%;
            margin: 0 auto;
            margin-top: 30px;
            /*color: greenyellow;*/
            color: black;
            cursor: pointer;
        }

        .done {
            background-color: sandybrown;
            color: black;
        }

        .perc {
            float: right;
            padding: 5px;
        }

        #reset {
            position: absolute;
        }
    </style>

    <script type="text/javascript">

        window.onload = function () {
            document.getElementById('reset').addEventListener("click", function () {
                resetUser();
            });
        };

        function doTest(testid) {
            window.location = "test.php?testid=" + testid;
        }

        function resetUser() {
            localStorage.removeItem("user");
            window.location = "index.php";
        }

        function getQuestionAnalysis(testid) {
            fetch('<?php echo $_SESSION['global_url'] ?>/resultAnalysis.php?testid=' + testid)
                .then((response) => {
                    return response.json();
                }).then((myJson) => {
                console.log(myJson);
                let temp = '';
                let myArr = [];
                myArrIdx = 0;
                myJson.forEach((item, idx, arr) => {
                    if (idx < (arr.length - 1)) {
                        if (item[1] === arr[(idx + 1)][1]) {
                            temp += item[0] + ", ";
                        } else {
                            temp += item[0] + ".";
                            myArr.push([item[1], temp]);
                            temp = '';
                            myArrIdx++;
                        }
                    } else { // last item
                        if (item[1] === arr[idx - 1][1]) { // in this case, the previous has not yet been pushed.
                            temp += item[0] + ".";
                            myArr.push([item[1], temp]);

                            // myArr[myArr.length - 1][1] = myArr[myArr.length-1][1] + item[0] + ".";
                            console.log("items are teh same");
                            // temp += item[0] + ".";
                            // myArr.push([item[1], temp]);
                        } else {
                            console.log("items are different");
                            myArr.push([item[1], item[0] + "."]);
                        }
                    }
                });
                console.log("Analysis: \r\n");
                let msg = '';

                for (bob of myArr) {
                    msg += (bob[0] === null ? 'zero' : bob[0]) + (bob[0] === '1' ? " correct answer:     " : " correct answers:   ") + bob[1] + "\r\n";
                }
                console.log(msg);
                alert(msg);
            });
        }
    </script>

<?php
print   "\n</head>\n<body>"; ?>

    <header style="text-align: center;">
        <img src="img/saenalLogoCropped.png" width="200px">
    </header>
<?php
print "\n<img id='reset' src='img/unlock.png' style='position: fixed;top: 0px; left: 0px;width: 48px; height: 48px;'>";
//print "<img id=\"reset\" src=\"../img/reset.png\" onclick='reset();'>";
print "\n<div class='header'><h2>" . $_SESSION['coursedesc'] . "</h2></div>";

//Get List of Classes the student belongs to
$sql = "SELECT * FROM tbl_stud_class JOIN tbl_classes
ON tbl_stud_class.fld_class_id=tbl_classes.fld_class_id
WHERE tbl_stud_class.fld_student_id='" . $_SESSION['studid'] . "'";
//echo "<br>$sql<br>";
mail("matt@notborder.org", "My subject", $sql);
$query = mysqli_query($conn, $sql);


while (list($stud, $class, , $classdesc) = mysqli_fetch_row($query)) {
//Get actual scores for this student
    $sql = "SELECT bob.fld_test_id, bob.fld_desc, bob.fld_retain, bob.fld_startdate, bob.fld_enddate, susan.fld_score
FROM (SELECT tbl_tests.fld_test_id, tbl_tests.fld_desc, tbl_tests.fld_retain,tbl_class_tests.fld_startdate, tbl_class_tests.fld_enddate
FROM (tbl_classes INNER JOIN tbl_class_tests ON tbl_classes.fld_class_id = tbl_class_tests.fld_classid)
INNER JOIN tbl_tests ON tbl_class_tests.fld_test_id = tbl_tests.fld_test_id
WHERE tbl_class_tests.fld_classid=" . $class . ") AS bob
LEFT JOIN (SELECT fld_test_id, fld_score FROM tbl_stud_testscore WHERE fld_student_id='" . $_SESSION['studid'] . "') AS susan
ON bob.fld_test_id = susan.fld_test_id
ORDER BY bob.fld_test_id";
    //echo "<br>query2<br>$sql<br>";
    $query2 = mysqli_query($conn, $sql) or die('something wrong   ' . $sql);
    $numStars = mysqli_num_rows($query2);
    $width = floor(100 / $numStars);
    $starSize = round(14 / $numStars, 1);
    if ($starSize > 4) $starSize = 4;
    print "\n<div id=\"stars\"><div class=\"starsClassTitle\">" . $classdesc . " class</div>";

    $tests = array(); // array to hold all of the tests to display


    while (list ($testid, $testdesc, $testRetain, $start, $end, $score) = mysqli_fetch_row($query2)) {
        // manage tests that have no score yet
        if ($score == NULL) {
            // echo "There is no score yet for test id $testid, $testdesc";
            $test = array();
            array_push($test, $testid);
            array_push($test, $testdesc);
            array_push($test, $score);
            array_push($test, convert_datetime($start));
            array_push($test, convert_datetime($end));
            array_push($test, $testRetain);

            array_push($tests, $test);
            continue;
        }


        // Get rank for test
        $sql = "SELECT rank
        FROM (SELECT tbl_stud_class.fld_student_id AS stud, fld_score, RANK() OVER(ORDER BY fld_score DESC) rank
        FROM tbl_stud_testscore INNER JOIN tbl_stud_class ON tbl_stud_testscore.fld_student_id = tbl_stud_class.fld_student_id
        WHERE tbl_stud_testscore.fld_test_id=" . $testid . " AND tbl_stud_class.fld_class_id=" . $class . ") AS ranks
        WHERE stud = '" . $stud . "'";
//echo "<br>queryRank<br>$sql<br>";
        $queryRank = mysqli_query($conn, $sql) or die('something wrong with rank query\n' . $sql);
        list ($rank) = mysqli_fetch_row($queryRank);

        // Get max, min, avg and median for test
        $sql = "SELECT
        Min(tbl_stud_testscore.fld_score) AS 최소,
        Max(tbl_stud_testscore.fld_score) AS 최대,
        Round((Avg(fld_score)),1) AS 평균,
        Count(tbl_stud_testscore.fld_score) AS 수
        FROM tbl_stud_testscore INNER JOIN tbl_stud_class ON tbl_stud_testscore.fld_student_id = tbl_stud_class.fld_student_id
        GROUP BY tbl_stud_testscore.fld_test_id, tbl_stud_class.fld_class_id
        HAVING (((tbl_stud_testscore.fld_test_id)=" . $testid . ") AND ((tbl_stud_class.fld_class_id)=" . $class . "))";
//echo "<br>queryAggregates<br>$sql<br>";
        $queryAggregates = mysqli_query($conn, $sql) or die('something wrong with aggregate query\n' . $sql);

        while (list ($min, $max, $avg, $count) = mysqli_fetch_row($queryAggregates)) {

            $test = array();
            array_push($test, $testid);
            array_push($test, $testdesc);
            array_push($test, $score);
            array_push($test, convert_datetime($start));
            array_push($test, convert_datetime($end));
            array_push($test, $testRetain);

            array_push($tests, $test);

            if ($score == 100) {
                print "\n<div class=\"stardiv\" style=\"width: $width%;font-size: " . $starSize . "em;\">&#x2605;<div style=\"font-size: 1rem;\">$testdesc
            <br>최소: " . $min . "%
            <br>최대: " . $max . "%
            <br>평균: " . $avg . "%
            <br>수: " . $count . "
            <br>순위: " . $rank . "
            </div></div>";
            } else {
                print"\n<div class=\"stardiv\" style=\"width: $width%;font-size: " . $starSize . "em;\">&#x2606;<div style=\"font-size: 1rem;\">$testdesc
            <br>최소: " . $min . "%
            <br>최대: " . $max . "%
            <br>평균: " . $avg . "%
            <br>수: " . $count . "
            <br>순위: " . $rank . "
            <br><br><button onclick='getQuestionAnalysis(" . $testid . ")'>Get Analysis</button>
            </div></div>";
            }
        }
    }
    print "\n<div style=\"clear: both\"></div>\n</div>";

    foreach ($tests as $val) {
//        echo $val[3]."<br>";
//        echo time();
        if ($val[3] > time() or $val[4] < time()) {
            continue;
        }

        if ((($val[2] < 100) && $val[5] == -1) || $val[2] === NULL) {
            if ($val[2] > 0) {
                echo "<div class='testChoice' onclick='doTest($val[0]);'> $val[1] <div class='perc'>$val[2]%</div></div>";
            } else {
                echo "<div class='testChoice' onclick='doTest($val[0]);'> $val[1] <div class='perc'></div></div>";
            }
        } else {
            echo "<div class='testChoice done' onclick='doTest($val[0]);'> $val[1]&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;COMPLETE&nbsp;&nbsp;$val[2]%</div>";
        }
    }


    print "\n<hr>";

}


print "</body></html>";

?>