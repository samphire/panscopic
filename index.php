<?php
/**
 * Created by IntelliJ IDEA.
 * User: matthew
 * Date: 2/16/2016
 * Time: 3:21 PM
 */
include("sessionheader.inc");
include("pageheader.inc");
?>
<link rel="stylesheet" href="css/spinner.css">
<link rel="stylesheet" href="css/index.css">

<script src="js/index.js?version=15"></script>

<script src="https://kit.fontawesome.com/c85b7f2375.js" crossorigin="anonymous"></script>
</head>

<body>
<header style="text-align: center;">
    <img src="img/saenalLogoCropped.png" id="logo">
</header>

<div id="setStudent" class="on">
    <div class="inner">
        <label for="student">Пользователь</label>
        <input type="text" id="student">
    </div>
</div><!--end setStudent-->

<div id="enterPass" class="on">
    <div class="inner">
        <label for="realPass">пароль</label>
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