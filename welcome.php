<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");

?>

<script src="https://kit.fontawesome.com/c85b7f2375.js" crossorigin="anonymous"></script>
<style>
    html {
        width: 100%;
        height: 100%;
        padding 0;
        margin 0;
    }

    body {
        background-color: #ECDFCD;
        font-size: x-large;
        font-family: 'ubunturegular', Arial, sans-serif;
    }

    .header, footer {
        text-align: center;
    }

    #cabs {
        display: none;
    }

    .cabChoice {
        border-radius: 3px;
        border: 1px solid #F6454F;
        background-color: #6AD9D9;
        padding: 1%;
        width: 90%;
        margin: 0 auto;
        margin-top: 10px;
        /*color: greenyellow;*/
        text-align: center;
        color: black;
        cursor: pointer;
        font-size: medium;
    }

    footer {
        background-color: #6AD9D9;
        font-size: large;
        position: fixed;
        width: 100%;
        bottom: 0;
        left: 0;
    }

    #greeting {
        text-align: center;
    }

    .testChoice {
        border-radius: 5px;
        border: 2px solid #F6454F;
        /*background-color: #333333;*/
        /*background-color: #6AD9D9;*/
        padding: 2%;
        background-color: #FFD503;
        width: 90%;
        margin: 0 auto;
        margin-top: 30px;
        /*color: greenyellow;*/
        text-align: center;
        color: black;
        cursor: pointer;
    }

    a {
        text-decoration: none;
        color: inherit;
    }

    i.fas {
        display: none;
    }

    i {
        color: rebeccapurple;
    }

    @media only screen and (min-width: 768px) {
        .testChoice {
            width: 40%;
            display: flex;
            justify-content: space-around;
        }
        i.fas {
            display: unset;
        }
    }
</style>
</head>
<body>
<header style="text-align: center;">
    <img src="img/bitmap.png" width="200px">
</header>
<?php
print "<div id='greeting'>Hello " . $_SESSION['studname'] . "<br>What would you like to do?</div>";
?>
<!--<div class="testChoice">Watch a video</div>-->
<!--<div class="testChoice" onclick="window.location='voxcab.php'">Learn some words</div>-->
<!--<div class="testChoice" onclick="window.location='earnpoints.php'">Earn some points</div>-->
<!--<div class="testChoice" onclick="window.location='math/index.html'">Do some math</div>-->

<div class="testChoice" onclick="chooseVoxcab('learn');"><i class="fas fa-assistive-listening-systems"></i>
    <div>Learn some words</div>
    <i class="fas fa-assistive-listening-systems"></i></div>
<div class="testChoice" onclick="chooseVoxcab('test');"><i class="fas fa-trophy"></i>
    <div>Earn some points</div>
    <i class="fas fa-trophy"></i></div>
<div class="testChoice" onclick="window.location='math/index.html'"><i class="fas fa-calculator"></i>
    <div>Do some math</div>
    <i class="fas fa-calculator"></i></div>
<?php
// Fetch the page data
$sql = "SELECT voxcabs.imgName, voxcabs.svgData, tbl_student_voxcab.voice_id, tbl_student_voxcab.id
FROM tbl_student_voxcab INNER JOIN voxcabs ON (tbl_student_voxcab.voxcab_id = voxcabs.id)
WHERE tbl_student_voxcab.start_date<Now() AND tbl_student_voxcab.end_date>Now() AND tbl_student_voxcab.student_id='" . $_SESSION['studid'] . "'
ORDER BY tbl_student_voxcab.start_date";
$query = mysqli_query($conn, $sql);
print "<section id='cabs'>";
while (list($imgName, $svgData, $voiceId, $id) = mysqli_fetch_row($query)) {
    $printName = substr($imgName, 0, -4);
    print "<div class='cabChoice' onclick='window.location=\"voxcab.php?voxy=$id\"'>$printName</div>";
}
print "</section>";
?>
<footer>&copysr; English 360 2020</footer>
<script>
    console.log("user: " + localStorage.getItem('user'));
    let elArray = Array.from(document.querySelectorAll(".testChoice"));

    function chooseVoxcab(type) {
        elArray.forEach((el) => {
            el.style.display = "none";
        });
        document.querySelector("#cabs").style.display = 'block';
        if (type === "test") {
            elArray = Array.from(document.querySelectorAll(".cabChoice"));
            elArray.forEach((el) => {
                console.info('changing onclick: ' + el.onclick);
                el.setAttribute('onclick', el.getAttribute('onclick').replace('voxcab', 'voxcabtest'));
            });
        }
    }
</script>
</body></html>
