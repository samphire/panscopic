<?php session_start();
include("sessionheader.inc");
include("pageheader.inc");

?>
<style>
    html{
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

    footer{
        background-color: #6AD9D9;
        font-size: large;
        position:fixed;
        width: 100%;
        bottom: 0;
        left: 0;
    }

    #greeting{
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
    a{
        text-decoration: none;
        color: inherit;
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
<div class="testChoice">Watch a video</div>
<div class="testChoice"><a href="voxcab.php">Learn some words</a></div>
<div class="testChoice">Earn some points</div>
<footer>&copysr; Alex English 2020</footer>
</body></html>
