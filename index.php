<?php
/**
 * Created by IntelliJ IDEA.
 * User: matthew
 * Date: 2/16/2016
 * Time: 3:21 PM
 */
include("sessionheader.inc");
include("pageheader.inc");
$sql = "SELECT * FROM tbl_courses";
$query = mysqli_query($conn, $sql);
?>
<link rel="stylesheet" href="css/spinner.css">
<style>
    body {
        background-color: white;
        font-size: x-large;
        font-family: 'ubunturegular', Arial, sans-serif;
    }

    #setCourse, #setPass, #enterPass, #setStudent {
        top: 30%;
        left: 0%;
        position: absolute;
        width: 90%;
        text-align: center;
        padding: 5%;
    }
    #setStudent{
        top: 10%;
    }
    #setCourse{
        top: 10%;
    }

    .inner {
        width: 70%;
        margin: 0 auto;
    }

    input {
        padding: 5px;
        margin: 10px;
    }

    .on {
        display: block;
    }

    .off {
        display: none;
    }

    option, select {
        font-size: x-large;
        margin-top: 1em;
        color: greenyellow;
        background-color: #333333;
        padding: 0.2em;
    }

    .selectCourse {
        border-radius: 5px;
        background-color: #333333;
        padding: 2%;
        width: 96%;
        margin: 0 auto;
        margin-top: 30px;
        color: greenyellow;
        cursor: pointer;
    }
</style>
<script src="js/index.js?version=10"></script>
</head>

<body>
<div id="setCourse" class="on">
    <div class="inner">
        <h2>Select Course</h2>

        <!--<h3>You won't have to set them again</h3>-->
        <?php
        $lists = array();
        while (list($courseid, $coursedesc) = mysqli_fetch_row($query)) {
            print"\n<div class=\"selectCourse\" onclick=\"setCourse($courseid, '$coursedesc', this)\">
                \n$coursedesc
                \n</div><!--end selectCourse-->";
            $sql = "SELECT * FROM tbl_students JOIN tbl_stud_course
                ON tbl_students.fld_student_id = tbl_stud_course.fld_student_id
                WHERE tbl_stud_course.fld_course_id = " . $courseid;
            $bob = array();
            array_push($bob, $sql);
            array_push($bob, $courseid);
            array_push($lists, $bob);
        }
        print "\n</div><!--end inner-->\n</div><!--end setCourse-->\n<div id=\"setStudent\" class=\"off\">\n<div class=\"inner\">";

        for ($i = 0; $i < count($lists); $i++) {
            $sql = $lists[$i][0];
            $query2 = mysqli_query($conn, $sql);
            print "\n<div id=\"course" . $lists[$i][1] . "\"> \nSelect User<br> \n<select onchange=\"setStudent(this);\">";
            print "\n<option value=\"\" disabled selected>select student</option>";
            while (list($id, $name, $pass) = mysqli_fetch_row($query2)) {
                if (empty($pass)) {
                    print "\n<option class=\"noPass\" value=\"$id\">$id, $name</option>";
                } else {
                    print "\n<option value=\"$id\">$id, $name</option>";
                }
            }
            print "\n</select>\n</div><!--end course" . $lists[$i][1] . "-->";
        }
        print "\n</div><!--end inner-->";
        print "\n</div><!--end setStudent-->";
        ?>

        <div id="setPass" class="off">
            <div class="inner">
                Create a Password:<br>
                <input type="text" id="pass1" autofocus><br>
                <input type="text" id="pass2" onkeypress="handleEnter(event, this)">
            </div>
            <!--end inner-->
        </div>
        <!--end setPass-->
        <div id="enterPass" class="off">
            <div class="inner">
                Enter Password:<br>
                <input type="password" id="realPass" onkeypress="handleEnter(event, this)" autofocus>
                <div id='spinner' class="sk-folding-cube" style="display:none;">
                    <div class="sk-cube1 sk-cube"></div>
                    <div class="sk-cube2 sk-cube"></div>
                    <div class="sk-cube4 sk-cube"></div>
                    <div class="sk-cube3 sk-cube"></div>
                </div>
            </div>
            <!--end inner-->
        </div>
        <!--end enterPass-->
</body>
</html>