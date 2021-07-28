<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");
?>
    <style type="text/css">

        @font-face {
            font-family: NanumMyeongjoExtraBold;
            src: local('NanumMyeongjo'), url('css/font/NanumMyeongjo.ttf');
        }

        html {
            font-size: 14px;
            text-decoration: none;
        }

        body {
            background-color: gainsboro;
            font-size: x-large;
            font-family: 'ubunturegular', Arial, sans-serif;

        }

        .questionBlock {
            /*background-color: #8F979A;*/
            background-color: #EAEDDA;
            /*background-color: #F4EFE1;*/
            background-color: #c3c99c;
            border: 1px solid black;
            border-radius: 5px;
            padding: 3%;
            margin-bottom: 1em;
        }

        .question {
            font-weight: bold;
        }

        input[type=radio] {
            width: 22px;
            height: 22px;
            padding: 10px;
            border-radius: 50px;
            margin-top: 25px;
        }

        select {
            font-size: 1em;
            width: 100%;

        }

        input[type=checkbox] {
            width: 2rem;
            height: 2rem;
            padding: 1rem;
            margin-bottom: 25px;
        }

        input[type=submit] {
            font-family: NanumMyeongjoExtraBold, sans-serif;
            font-size: 1.4rem;
            border: 2px solid #333333;
            border-radius: 0.2rem;
            box-shadow: 3px 3px 5px black;
            padding: 0.4rem;
            margin-bottom: 3rem;
            color: #EAEDDA;
            color: orangered;
            background-color: rgba(66, 66, 66, 0.5);
            position: fixed;
            bottom: 0;
            right: 15%;
        }

        input[type=submit]:hover {
            background-color: #333333;
            color: #ffb110;
        }

        input[type=submit]:active {
            background-color: #444444;
            color: red;
            box-shadow: 1px 1px 5px black;
            transform: translate3d(2px, 2px, 0px);
        }

        input[type=text] {
            font-size: 1.3rem;
            padding: 0.2em;
            /*margin-left: 2rem;*/
        }

        .rubrik {
            margin-top: 2rem;
            padding: 0.5rem 1.5rem;
            border: 1px solid blue;
            border-radius: 0.1rem;
            background-color: rgba(100, 149, 237, 0.2);
            display: inline-block;
            color: #111111;
            font-weight: bold;
            font-size: 1.5rem;
            margin-left: auto;
            margin-right: auto;
            font-family: 'Nanum Gothic Coding', monospace;
        }

        img.dropshadow {
            border: 0px solid brown;
            box-shadow: orange 0 0 10px;
            border-radius: 7px;
            margin: 55px auto 25px auto;
            display: block;
            width: 100%;
        }

        img.smaller {
            border: 0px solid brown;
            box-shadow: orange 0 0 8px;
            border-radius: 5px;
            margin: 55px auto 25px auto;
            display: block;
        }

        .widg {
            display: inline-block;
            transform: scale(0.3, 0.3);
            vertical-align: baseline;
            margin-right: -40px;
            margin-left: -40px;
        }

        .done {
            color: firebrick;
            font-weight: bolder;
        }

        .audioBtnDiv {
            text-align: right;
        }

        img.audioBtn {
            right: 0;
            width: 4rem;
            -webkit-transition-duration: 0.2s; /* Safari */
            transition-duration: 0.2s;
        }

        img.audioBtn:hover {
            cursor: pointer;
            transform: scale(1.1, 1.1);
        / / box-shadow: 0 12 px 16 px 0 rgba(0, 0, 0, 0.24), 0 17 px 50 px 0 rgba(0, 0, 0, 0.19);
        }

        img.audioBtn:active {
            transform: translateY(2px);
        }

        @media screen and (min-width: 768px) {
            .widg {
                transform: scale(0.6, 0.6);
                margin-right: -20px;
                margin-left: -20px;
            }

            #container {
                width: 70%;
                margin: 0 auto;
            }

            html {
                font-size: 22px;
            }

            body {
                font-size: xx-large;
            }

            input[type=checkbox] {
                width: 1.4rem;
                height: 1.4rem;
                padding: 1rem;
                margin-bottom: 25px;
            }

            img.dropshadow {
                width: 90%;
            }

            img.audioBtn {
                width: 2rem;
            }

            .audioBtnDiv {
                text-align: left;
            }
        }

    </style>
    <script>

        window.onload = function () {
            var imgs = document.getElementsByClassName("dropshadow");
            for (var i = 0; i < imgs.length; i++) {
                //alert("image " + (i + 1) + ", " + imgs[i].tagName + ", " + imgs[i].naturalWidth);
                if (imgs[i].naturalWidth < 1200) {
                    //imgs2[i].classList.replace("dropshadow", "smaller");
                    imgs[i].classList.add("smaller");
                }
            }
            var imgs3 = document.getElementsByClassName("smaller");

            for (var i = 0; i < imgs3.length; i++) {
                //alert("image " + (i + 1) + ", " + imgs3[i].tagName + ", " + imgs3[i].naturalWidth);
                imgs3[i].classList.remove("dropshadow");
            }
        }
    </script>


    <script src="js/howler.core.min.js"></script>

    </head>
    <body>
    <div id="container">

<?php
//print("<h5>student: ".$_SESSION['studid'].", response table ".$_SESSION['qnstable']."</h5>");
print "\n<object id='Player' height='0' width='0' classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6'></object>";

function baitchtmlentities($str)
{
    $str = str_replace("<", "&lt;", $str);
    $str = str_replace(">", "&gt;", $str);
    return $str;
}


//get TEST data

//print("<br>post data: ".$_POST['studid'].", ".$_POST['testid']);
//print("<br>get data: ".$_GET['studid'].", ".$_GET['testid']);
//print("<br>session data: ".$_SESSION['studid'].", ".$_SESSION['testid']);

if (isset($_GET['testid'])) {
    $_SESSION['testid'] = $_GET['testid'];
}

if (isset($_GET['studid'])) {
    $_SESSION['studid'] = $_GET['studid'];
}

$sql = "SELECT * from tbl_tests WHERE fld_test_id='" . $_SESSION['testid'] . "'";
//echo $sql;
$query = mysqli_query($conn, $sql) or die("strange problem");

//list(,$desc,,,,$end,$shuffle,$pwrong,$panswer,$oneshot,$retain,$timer,$qnstable) = mysql_fetch_row($query);
list(, $_SESSION['desc'], $_SESSION['course'], , , , $_SESSION['end'], $_SESSION['shuffle'], $_SESSION['pwrong'],
    $_SESSION['panswer'], $_SESSION['oneshot'], $_SESSION['ppraccy'], $_SESSION['retain'], $_SESSION['timer'],
    $_SESSION['qnstable']) = mysqli_fetch_row($query);

if ($_SESSION['qnstable'] == NULL) {
    die("There are no questions for this test");
}


$sql = "SELECT * from tbl_qns" . $_SESSION['qnstable'];
$query = mysqli_query($conn, $sql) or die("some problem getting questions");
$_SESSION['numq'] = mysqli_num_rows($query);

//STOPS ENTER KEY FROM SUBMITTING FORM
print "\n\n<script type='text/javascript'>
    \nfunction stopRKey(evt) {
    \nvar evt = (evt) ? evt : ((event) ? event : null);
    \nvar node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null);
    \nif (evt.keyCode == 13) {return false;}
    \n}
    \ndocument.onkeypress = stopRKey;
    \n</script>";
print "\n</head>\n<body>";

//get Questions
if ($_SESSION['retain'] == -1) {
    $sql = "SELECT * FROM tbl_response" . $_SESSION['qnstable'] . " WHERE fld_student_id='" . $_SESSION['studid'] . "'";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    if ($data) {
        $sql = "SELECT * FROM tbl_qns" . $_SESSION['qnstable'] . " INNER JOIN tbl_response" . $_SESSION['qnstable'] . " ON tbl_qns" . $_SESSION['qnstable'] . ".fld_qnum = tbl_response" . $_SESSION['qnstable'] . ".fld_question_id
        WHERE tbl_response" . $_SESSION['qnstable'] . ".fld_response<> BINARY tbl_qns" . $_SESSION['qnstable'] . ".fld_answer AND tbl_response" . $_SESSION['qnstable'] . ".fld_student_id='" . $_SESSION['studid'] . "' ORDER BY tbl_qns" . $_SESSION['qnstable'] . ".fld_qnum";
        //echo $sql;
        $query = mysqli_query($conn, $sql);
        $numrows = mysqli_num_rows($query);
        if ($numrows < 1) {
            print "<h1>You have already completed this test</h1>";
            $sql = "SELECT * from tbl_qns" . $_SESSION['qnstable'];
            $query = mysqli_query($conn, $sql);
            $done = true;
        }
    } else {
        $sql = "SELECT * from tbl_qns" . $_SESSION['qnstable'];
        $query = mysqli_query($conn, $sql);
    }
} else {
    $sql = "SELECT * FROM tbl_response" . $_SESSION['qnstable'] . " WHERE fld_student_id='" . $_SESSION['studid'] . "'";
    $query = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($query);

    if ($data) {
        print "<h1>You have already completed this test</h1>";
        $sql = "SELECT * from tbl_qns" . $_SESSION['qnstable'];
        $query = mysqli_query($conn, $sql);
        $done = true;
    } else {
        $sql = "SELECT * from tbl_qns" . $_SESSION['qnstable'];
        $query = mysqli_query($conn, $sql);
    }
}

//QUESTIONS

print "\n\n\n<form enctype='multipart/form-data' name='testqns' action='" . $_SESSION['global_url'] .
    "/result.php' method='post' autocomplete='off'>\n\n";

//Put questions into array
$counter = 0;
while (list($a, , $b, $c, $d, $e, $f, $m, $n, $g, $h, $i, $j, $k, $l) = mysqli_fetch_row
($query)) {
    $queshy[$counter]['qnum'] = $a;
    $queshy[$counter]['txt1'] = $b;

    $bob = htmlentities($c, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt2'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($d, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt3'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($e, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt4'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($f, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt5'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($m, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt6'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($n, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['txt7'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);

    $bob = htmlentities($g, ENT_QUOTES, 'UTF-8');
    $queshy[$counter]['answer'] = htmlspecialchars_decode($bob, ENT_NOQUOTES);
    $queshy[$counter]['type'] = $h;
    $queshy[$counter]['rubrik'] = $i;
    $queshy[$counter]['image'] = $j;
    $queshy[$counter]['audio'] = $k;
    $queshy[$counter]['video'] = $l;

    $counter++;
}
if ($_SESSION['shuffle'] == -1) {
    shuffle($queshy);
}

//Print Questions on Page
foreach ($queshy as $val => $wow) {
//    $qnumdisplay = $val + 1; //prints from 'question 1' even when retain correct
    $qnumdisplay = $queshy[$val]['qnum']; //prints the actual question number in the test data
    $lenput = strlen($queshy[$val]['answer']) + 0;

    if ($queshy[$val]['rubrik'] <> "") {
        print "\n<span class='rubrik'>" . $queshy[$val]['rubrik'] . "</span><hr>";
    }

    if ($queshy[$val]['image'] <> "" & $queshy[$val - 1]['image'] != $queshy[$val]['image']) { // Don't print the same image twice!
        print "\n\n\n<img src='" . $_SESSION['global_url'] .
            "/images/" . $queshy[$val]['image'] . "' align='center' class='dropshadow' alt='img'>";
    }

    if ($queshy[$val]['audio'] <> "" & $queshy[$val - 1]['audio'] != $queshy[$val]['audio']) {
        print "<script>var sound" . $val . " = new Howl({ src: ['media/audio/" . $queshy[$val]['audio'] . "'], preload: true});</script>";
//        print "\n\n<input type='button' name='bob3' value='play' OnClick='sound".$val.".play();'>";
        print "\n\n\n<div class='audioBtnDiv'>
        <img class='audioBtn' src='img/audioplay.png' onclick='sound" . $val . ".play();'>
        <img class='audioBtn' src='img/audiopause.png' onclick='sound" . $val . ".pause();'>
        <img class='audioBtn' src='img/audiostop.png' onclick='sound" . $val . ".stop();'>
        </div>";
    }

    if ($queshy[$val]['video'] <> "") {
        print "\n\n\n<object id='Player$val' height='240' width='320' classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6' type='application/x-oleobject' style='float:right;'>\n<PARAM name='uiMode' value='none'>
</object>";
        print "\n\n\n<input type='button' name='bob' value='play' OnClick='Player$val.url=" . chr(34) . "media/video/" . $queshy[$val]['video'] . chr(34) . "; Player$val.controls.play();'>";
    }

    print "\n<div class='questionBlock'>";

    switch ($queshy[$val]['type']) {
        case "1":

            if (substr($queshy[$val]['txt1'], 0, 8) == "Question") {
                print "\n<span class='question'>" . substr($queshy[$val]['txt1'], 0, 11) . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . substr($queshy[$val]['txt1'], 12);
            } else {
                print "\n<span class='question'>Q " . $qnumdisplay . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            if ($done) {
                print "\n\n&nbsp;&nbsp;&nbsp;<span class='done'>" . baitchtmlentities($queshy[$val]['answer']) . "</span>";
            } else {
                //         print "\n\n<input type='text' size='$lenput' name='response" . $queshy[$val]['qnum'] . "' /> " . $queshy[$val]['txt2'] . "<br>";
                print "\n\n<textarea wrap='off' rows='1' style='resize: none; width: 100%; font-size: 2rem; margin-top: 15px; border: 1px solid gray;' name='response" . $queshy[$val]['qnum'] . "'></textarea> " . $queshy[$val]['txt2'] . "<br>";
            }
            print"</div>";
            break;


        case "2":

            if (substr($queshy[$val]['txt1'], 0, 8) == "Question") {
                print "\n<span class='question'>" . substr($queshy[$val]['txt1'], 0, 11) . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . substr($queshy[$val]['txt1'], 12);
            } else {
                print "\n<span class='question'>Q " . $qnumdisplay . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            $brad = "<br><br>\n<select name='response" .
                $queshy[$val]['qnum'] . "'>\n<option></option>\n<option" . ($done ? ($queshy[$val]['txt2'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt2']) . ($done ? ($queshy[$val]['txt'] == $queshy[$val]['answer'] ? " selected" : "") : "") .
                "</option>\n<option" . ($done ? ($queshy[$val]['txt3'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt3']) . "</option>";

            if ($queshy[$val]['txt4'] <> "") {
                $brad .= "\n <option" . ($done ? ($queshy[$val]['txt4'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt4']) . " </option >";
            }
            if ($queshy[$val]['txt5'] <> "") {
                $brad .= "\n <option" . ($done ? ($queshy[$val]['txt5'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt5']) . " </option >";
            }
            if ($queshy[$val]['txt6'] <> "") {
                $brad .= "\n <option" . ($done ? ($queshy[$val]['txt6'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt6']) . " </option >";
            }
            if ($queshy[$val]['txt7'] <> "") {
                $brad .= "\n <option" . ($done ? ($queshy[$val]['txt7'] == $queshy[$val]['answer'] ? " selected" : "") : "") . ">" . baitchtmlentities($queshy[$val]['txt7']) . " </option >";
            }
            $brad .= "\n</select> \n<br></div>";
            print $brad;
            break;

        case "3":
            if (substr($queshy[$val]['txt1'], 0, 8) == "Question") {
                print "\n<span class='question'>" . substr($queshy[$val]['txt1'], 0, 11) . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . substr($queshy[$val]['txt1'], 12);
            } else {
                print "\n<span class='question'>\nQ" . $qnumdisplay . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            $izzy = "";
//            $izzy = "\n<br><br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "a' value=" . chr(34) . $queshy[$val]['txt2'] . chr(34) . ($done ? ($queshy[$val]['txt2'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "a'>" . baitchtmlentities($queshy[$val]['txt2']) . "</label>";
//            $izzy .= "\n<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "b' value=" . chr(34) . $queshy[$val]['txt3'] . chr(34) . ($done ? ($queshy[$val]['txt3'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "b'>" . baitchtmlentities($queshy[$val]['txt3']) . "</label>";

            if ($queshy[$val]['txt2'][0] == '~') {
                print "<script>var sound" . $queshy[$val]['qnum'] . "a = new Howl({ src: ['media/audio/" . $queshy[$val]['txt2'] . "'], preload: true});</script>";
                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "a' value=" . chr(34) . $queshy[$val]['txt2'] . chr(34) . ($done ? ($queshy[$val]['txt2'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "a.stop();sound" . $queshy[$val]['qnum'] . "a.play();'>";
            } else {
                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "a' value=" . chr(34) . $queshy[$val]['txt2'] . chr(34) . ($done ? ($queshy[$val]['txt2'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "a'>" . baitchtmlentities($queshy[$val]['txt2']) . "</label>";
            }


            if ($queshy[$val]['txt3'][0] == '~') {
                print "<script>var sound" . $queshy[$val]['qnum'] . "b = new Howl({ src: ['media/audio/" . $queshy[$val]['txt3'] . "'], preload: true});</script>";
                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "b' value=" . chr(34) . $queshy[$val]['txt3'] . chr(34) . ($done ? ($queshy[$val]['txt3'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "b.stop();sound" . $queshy[$val]['qnum'] . "b.play();'>";
            } else {
                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "b' value=" . chr(34) . $queshy[$val]['txt3'] . chr(34) . ($done ? ($queshy[$val]['txt3'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "b'>" . baitchtmlentities($queshy[$val]['txt3']) . "</label>";
            }


            if ($queshy[$val]['txt4'] <> "") {
//                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "c' value=" . chr(34) . $queshy[$val]['txt4'] . chr(34) . ($done ? ($queshy[$val]['txt4'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "c'>" . baitchtmlentities($queshy[$val]['txt4']) . "</label>";
                if ($queshy[$val]['txt4'][0] == '~') {
                    print "<script>var sound" . $queshy[$val]['qnum'] . "c = new Howl({ src: ['media/audio/" . $queshy[$val]['txt4'] . "'], preload: true});</script>";
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "c' value=" . chr(34) . $queshy[$val]['txt4'] . chr(34) . ($done ? ($queshy[$val]['txt4'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "c.stop();sound" . $queshy[$val]['qnum'] . "c.play();'>";
                } else {
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "c' value=" . chr(34) . $queshy[$val]['txt4'] . chr(34) . ($done ? ($queshy[$val]['txt4'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "c'>" . baitchtmlentities($queshy[$val]['txt4']) . "</label>";
                }
            }
            if ($queshy[$val]['txt5'] <> "") {
//                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "d' value=" . chr(34) . $queshy[$val]['txt5'] . chr(34) . ($done ? ($queshy[$val]['txt5'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "d'>" . baitchtmlentities($queshy[$val]['txt5']) . "</label>";
                if ($queshy[$val]['txt5'][0] == '~') {
                    print "<script>var sound" . $queshy[$val]['qnum'] . "d = new Howl({ src: ['media/audio/" . $queshy[$val]['txt5'] . "'], preload: true});</script>";
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "d' value=" . chr(34) . $queshy[$val]['txt5'] . chr(34) . ($done ? ($queshy[$val]['txt5'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "d.stop();sound" . $queshy[$val]['qnum'] . "d.play();'>";
                } else {
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "d' value=" . chr(34) . $queshy[$val]['txt5'] . chr(34) . ($done ? ($queshy[$val]['txt5'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "d'>" . baitchtmlentities($queshy[$val]['txt5']) . "</label>";
                }
            }
            if ($queshy[$val]['txt6'] <> "") {
//                $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "e' value=" . chr(34) . $queshy[$val]['txt6'] . chr(34) . ($done ? ($queshy[$val]['txt6'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "e'>" . baitchtmlentities($queshy[$val]['txt6']) . "</label>";

                if ($queshy[$val]['txt6'][0] == '~') {
                    print "<script>var sound" . $queshy[$val]['qnum'] . "e = new Howl({ src: ['media/audio/" . $queshy[$val]['txt6'] . "'], preload: true});</script>";
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "e' value=" . chr(34) . $queshy[$val]['txt6'] . chr(34) . ($done ? ($queshy[$val]['txt6'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "e.stop();sound" . $queshy[$val]['qnum'] . "e.play();'>";
                } else {
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "e' value=" . chr(34) . $queshy[$val]['txt6'] . chr(34) . ($done ? ($queshy[$val]['txt6'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "e'>" . baitchtmlentities($queshy[$val]['txt6']) . "</label>";
                }
            }
            if ($queshy[$val]['txt7'] <> "") {
                if ($queshy[$val]['txt7'][0] == '~') {
                    print "<script>var sound" . $queshy[$val]['qnum'] . "f = new Howl({ src: ['media/audio/" . $queshy[$val]['txt7'] . "'], preload: true});</script>";
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "f' value=" . chr(34) . $queshy[$val]['txt7'] . chr(34) . ($done ? ($queshy[$val]['txt7'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<img class='audioBtn' src='img/audioplay.png' onclick='sound" . $queshy[$val]['qnum'] . "f.stop();sound" . $queshy[$val]['qnum'] . "f.play();'>";
                } else {
                    $izzy .= "<br>\n<input type='radio' name='response" . $queshy[$val]['qnum'] . "' id='" . $queshy[$val]['qnum'] . "f' value=" . chr(34) . $queshy[$val]['txt7'] . chr(34) . ($done ? ($queshy[$val]['txt7'] == $queshy[$val]['answer'] ? " checked style='box-shadow: 2px 2px 2px red'" : "") : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "f'>" . baitchtmlentities($queshy[$val]['txt7']) . "</label>";
                }
            }

            print $izzy;
            print "</div>";
            break;


        /*case "4":
            if (substr($queshy[$val]['txt1'],0,8)=="Question"){
            print "\n\n\n <span class='question' > ". substr($queshy[$val]['txt1'],0,11)."</span >&nbsp;&nbsp;&nbsp;&nbsp;".substr($queshy[$val]['txt1'],12);
            }
            else{
            print "\n\n\n <span class='question' > Question " . $qnumdisplay . " </span >&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            print "\n <br><br > \n<input type = 'hidden' name = 'MAX_FILE_SIZE' value = '8000000' /><input type = 'file' name = 'file' ><br ><br > ";
            break;*/

        case "5":
            //Create array holding true and false for each checkbox

            $chkArray = explode(",", $queshy[$val]['answer']);

            if (!$done) {
                for ($e = 0; $e < count($chkArray); $e++) {
                    $chkArray[$e] = "false";
                }
            }


            if (substr($queshy[$val]['txt1'], 0, 8) == "Question") {
                print "\n<span class='question'>" . substr($queshy[$val]['txt1'], 0, 11) . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . substr($queshy[$val]['txt1'], 12);
            } else {
                print "\n<span class='question'>\nQ" . $qnumdisplay . " </span>&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            $izzy = "\n<br><br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "a' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[0] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "a'> " . baitchtmlentities($queshy[$val]['txt2']) . "</label><br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "b' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[1] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "b'>" . baitchtmlentities($queshy[$val]['txt3']) . "</label>";
            $jav = "\n<script type='text/javascript'>\nfunction bob" . $queshy[$val]['qnum'] . "(){\nvar cat = document.getElementById('" . $queshy[$val]['qnum'] . "a').checked + ',' + document.getElementById('" . $queshy[$val]['qnum'] . "b').checked + ','";
            $jav_mid = " + 'false,false,false,false,';";

            if ($queshy[$val]['txt4'] <> "") {
                $izzy .= "<br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "c' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[2] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "c'>" . baitchtmlentities($queshy[$val]['txt4']) . "</label>";
                $jav .= " + document.getElementById('" . $queshy[$val]['qnum'] . "c').checked + ','";
                $jav_mid = " + 'false,false,false,';";
            }

            if ($queshy[$val]['txt5'] <> "") {
                $izzy .= "<br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "d' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[3] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "d'>" . baitchtmlentities($queshy[$val]['txt5']) . "</label>";
                $jav .= " + document.getElementById('" . $queshy[$val]['qnum'] . "d').checked + ','";
                $jav_mid = " + 'false,false,';";
            }
            if ($queshy[$val]['txt6'] <> "") {
                $izzy .= "<br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "e' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[4] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "e'>" . baitchtmlentities($queshy[$val]['txt6']) . "</label>";
                $jav .= " + document.getElementById('" . $queshy[$val]['qnum'] . "e').checked + ','";
                $jav_mid = " + 'false,';";
            }
            if ($queshy[$val]['txt7'] <> "") {
                $izzy .= "<br>\n<input type='checkbox' id='" . $queshy[$val]['qnum'] . "f' onclick='bob" . $queshy[$val]['qnum'] . "()'" . ($chkArray[5] == "true" ? "checked style='box-shadow: 2px 2px 2px red'" : "") . " />&nbsp;&nbsp;<label for='" . $queshy[$val]['qnum'] . "f'>" . baitchtmlentities($queshy[$val]['txt7']) . "</label>";
                $jav .= " + document.getElementById('" . $queshy[$val]['qnum'] . "f').checked + ','";
                $jav_mid = "";
            }

            $izzy .= "\n<input type='hidden' name='response" . $queshy[$val]['qnum'] . "' id='dick" . $queshy[$val]['qnum'] . "'>";
            $jav .= $jav_mid;
            $jav .= "\ndocument.getElementById('dick" . $queshy[$val]['qnum'] . "').value = cat;\n}\n </script > ";


//            echo "<h1>$izzy</h1>";

            error_log($izzy, 3, "bob.txt");

            print $izzy;
            print $jav;
            print"</div>";
            break;

        case "6":
            $myArray = explode("/", $queshy[$val]['txt2']);
            shuffle($myArray);

            if (substr($queshy[$val]['txt1'], 0, 8) == "Question") {
                print "\n<span class='question'>" . substr($queshy[$val]['txt1'], 0, 11) . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . substr($queshy[$val]['txt1'], 12);
            } else {
                print "\n<span class='question'>Q " . $qnumdisplay . "</span>&nbsp;&nbsp;&nbsp;&nbsp;" . $queshy[$val]['txt1'];
            }
            if ($done) {
                print "\n\n&nbsp;&nbsp;&nbsp;<span class='done'>" . baitchtmlentities($queshy[$val]['answer']) . "</span>";
            } else {
                print "<div id=drag" . $queshy[$val]['qnum'] . "><em style='font-size: small'>Click to Add</em><br>";
                for ($x = 0; $x < count($myArray); $x++) {
                    print "\n<div class='draggable drag-drop' style='cursor: pointer; color: SlateGray; display: inline-block; vertical-align: top; height: 1.4em; padding: 0 10px; background-color: whitesmoke; margin: 15px 2px; border-radius: 2px; border: 1px solid orangered;'";
                    print " id='drop" . $x . "' onclick='moveIt(this," . $queshy[$val]['qnum'] . ")'>" . baitchtmlentities($myArray[$x]) . "</div>";
                }

//                print "\n\n<input type='text' id='result" . $queshy[$val]['qnum'] . "' style='color: black; margin-top: 15px;' class='dropzone' size='$lenput' name='response" . $queshy[$val]['qnum'] . "' /> ";
                print "\n\n<textarea wrap='off' rows='1' id='result" . $queshy[$val]['qnum'] . "' style='width: 100%; border: 1px solid gray; font-size: 2rem; resize: none; color: black; margin-top: 15px;' class='dropzone' name='response" . $queshy[$val]['qnum'] . "'></textarea>";
                print "</div>";
//                print "<div><img src='img/reset.png' class='widg' onclick='delAll" . $queshy[$val]['qnum'] . "();'><img src='img/backdelete.png' class='widg' onclick='delBack" . $queshy[$val]['qnum'] . "();'></div>";
                print "\n<div>\n<img src='img/reset.png' class='widg' onclick='delAll" . $queshy[$val]['qnum'] . "();'>\n<img src='img/backdelete.png' class='widg' onclick='delBack(" . $queshy[$val]['qnum'] . ");'>\n</div>";
            }

//            print "<div style='clear: both;'>&nbsp;</div></div>";
            print "</div>";
            print "<script>function delBack" . $queshy[$val]['qnum'] . "(){document.getElementById('result" . $queshy[$val]['qnum'] . "').value = document.getElementById('result" . $queshy[$val]['qnum'] . "').value.slice(0, -1);restore" . $queshy[$val]['qnum'] . "();}</script>";
            print "<script>function delAll" . $queshy[$val]['qnum'] . "(){document.getElementById('result" . $queshy[$val]['qnum'] . "').value = '';restore" . $queshy[$val]['qnum'] . "();}";
            print "\n\nfunction restore" . $queshy[$val]['qnum'] . "(){\n\tvar els = document.querySelectorAll('#drag" . $queshy[$val]['qnum'] . " .draggable');\n\tvar i;
            for(i=0;i<els.length;i++){
            els[i].style.visibility = 'visible';
            els[i].style.display = 'inline-block';
            }
            
            }</script>";

            break;


    }

}
if (!$done) {
    print("<input type='hidden' name='studid' value='" . $_SESSION['studid'] . "'>");
    print("<input type='hidden' name='qnstable' value='" . $_SESSION['qnstable'] . "'>");
    print("<input type='hidden' name='numq' value='" . $_SESSION['numq'] . "'>");
    print("<input type='hidden' name='testid' value='" . $_SESSION['testid'] . "'>");
    print("<input type='hidden' name='retain' value='" . $_SESSION['retain'] . "'>");

    print "\n\n <input type = 'submit' name = 'submit' id = 'sendbutton' value = \"보내기 &#x27a4;\">";
}

if ($_SESSION['oneshot'] == -1 && $_SESSION['ppraccy'] == -1) {
    print"\n<hr /><strong>연습만?</strong>  <input type='checkbox' name='praccy' align='left'>";
}

if ($_SESSION['oneshot'] == -1 && $_SESSION['ppraccy'] <> -1) {
    print "
<script>
    var inputs;
    window.onload = () => {
        inputs = document.querySelectorAll(\"input\");
        for (let myInput of inputs) {
            myInput.addEventListener('click', checkAllAnswered);
        }
        document.getElementById(\"sendbutton\").hidden = true;
    }

    function checkAllAnswered() {
        let clicked = 0;
        let isAllDone = false;
        let numq = " . $_SESSION['numq'] . ";
        for (let radio of inputs) {
            if (radio.checked) {
                clicked++;
            }
        }
        console.log(\"in checkAllAnswered. Clicked = \" + clicked);
        if (clicked === numq) {
            isAllDone = true;
        }
        if (isAllDone) {
            document.getElementById(\"sendbutton\").hidden = false;
        }
    }
</script>
";
}

if ($_SESSION['studid'] == "147") {
    print("\n<label for='prof'>delete all results?</label>");
    print("\n<input id='prof' type='checkbox' name='prof'>");
}
print "\n</form>\n</div>\n";

print "\n<script src='smart.js'></script>";

print "\n</body>\n</html>";


