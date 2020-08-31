var soundsNo = ['no', 'nooo', 'notright', 'notquiteright', 'kidding'];
var soundsYes = ['goodjob', 'ohyeah', 'ugotit', 'welldone', 'yes'];
var hurryup = ['comeon', 'hurryup', 'waitingfor', 'yawn'];
var wordlist = [];

var timer;
var hurrytimer;
var currentItemName;
var currentIndex = 0;
var audio;
var score = 0;
var tries = 0;
var numWords = 0;


function populateWordlist(type) { //

    if(document.getElementById("container").firstElementChild === null){
        // document.getElementById("start_button").className = "hide";
        document.getElementById("start_button").innerText = "시험이 없습니다!\n잘 시세요";
        setTimeout(function () {
            window.history.back();
        }, 2000);
        return;
    }


    var mySVGString = document.getElementById("container").firstElementChild.innerHTML;
    var patt = /playSprite\('(.*?)'/g;
    if (type == "test") {
        patt = /check\('(.*?)'/g;
    }
    var result = mySVGString.match(patt);
    result.forEach(function (item) {
        wordlist.push((type == "test" ? item.substring(7, item.length - 1) : item.substring(12, item.length - 1)));
        console.log("pushing " + item);
    });
    wordlist = Array.from(new Set(wordlist)); // Set in ECMA6 removes duplicates
    numWords = wordlist.length;
}

function playSprite(name) {
    const bob = "audio/" + name + ".wav";
    document.getElementById("bob").src = bob;
    document.getElementById("bob").play();
    let idx = wordlist.findIndex(function (value, index) {
        return value === name;
    });
    if (idx > -1) {
        wordlist.splice(idx, 1);
    }
    if (wordlist.length < 4) {
        showToast();
    }
}


function printInfo() {
    console.log("******* Print Info *******");
    console.log("current: \n" + currentIndex + " : " + wordlist[currentIndex]);
    console.log("whole list\n");
    wordlist.forEach(function (item, idx) {
        console.log(idx + " : " + item);
    });
    console.log("****************** *******");
}

function doNext() {
    document.getElementById("start_button").className = "hide";
    printInfo();
    currentItemName = wordlist[currentIndex];
    if (currentIndex == wordlist.length) {
        const myScore = Math.floor((score / tries) * 100);
        putScore(myScore);
    }
    playSprite(wordlist[currentIndex]);
}

function putScore(score) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            if(xhttp.responseText === "delete"){
                msg = "Your 5th perfect score! You will never see this test again!!!";
            } else{
                const myDate = new Date(xhttp.responseText);
                myDate.setMinutes(myDate.getMinutes() - myDate.getTimezoneOffset());
                msg = "You can take this test again on \n" + myDate.toDateString() + "\nat " + myDate.getHours() + "시 " + myDate.getMinutes() + "분";
            }
            alert(msg);
            showTestToast(score);
        }
    };
    const url = "http://notborder.org/scopic/putVoxcabScore.php";
    xhttp.open("POST", url, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("score=" + score + "&testid=" + document.getElementById("id").value +
        "&start_date=" + document.getElementById("startDate").value +
        "&end_date=" + document.getElementById("endDate").value +
        "&time=" + document.getElementById("time").value +
        "&num_perfect=" + document.getElementById("numPerfect").value);
}

function check(name) {
    tries += 1;
    if (name == currentItemName) {
        playSprite(soundsYes[Math.floor(Math.random() * soundsYes.length)]);
        score += 1;
        // currentIndex++;

        // in order to get some flash of recognition, you have to set up each element in the svg with its own unique id, then access that to animate opacity to 1 and back to 0 within, say 0.2 seconds.


        // document.getElementsByTagName("polygon").item(0).style.opacity = 0.3;
        // for(const myEl of document.getElementsByTagName("polygon")){
        //     myEl.style.opacity = 0.7;
        // }
        setTimeout(doNext, 1500);

    } else {
        playSprite(soundsNo[Math.floor(Math.random() * soundsNo.length)]);
        setTimeout(function () {
            playSprite(currentItemName);
        }, 1500);
    }
}

function setTimer() {
    clearInterval(hurrytimer);
    hurrytimer = setInterval(hurry, 9000);

    function hurry() {
        playSprite('comeon');
    }
}

function showTestToast(score){
    console.log("in show toast");
    var testToast = document.getElementById("testSnackbar");
    let toastClone = testToast.cloneNode(true);
    document.getElementById("container").appendChild(toastClone);
    toastClone.innerText = "Your score is " + score + "%";

    if(score == 100){
        toastClone.innerText = "Your score is " + score + "%\n" + " Perfect!";
        const bob = "audio/perfect.mp3";
        document.getElementById("bob").src = bob;
        document.getElementById("bob").play();
    }
    toastClone.className= "toast show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function () {
        toastClone.className = toastClone.className.replace("show", "");
    }, 3000);

    // And go back to the previous page
    setTimeout(function () {
        window.history.back();
    }, 4000);
}

function showToast() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    if (typeof (x) == 'undefined' || x == null) {
        return;
    }
    let toastClone = x.cloneNode(true);
    document.getElementById("container").appendChild(toastClone);
    if (wordlist.length > 0) {
        toastClone.innerText = wordlist.length === 1 ? "There is 1 word to find" : "There are " + wordlist.length + " words to find";
        // Add the "show" class to DIV
    } else {
        setTimeout(function () {
            toastClone.innerText = "Well Done!\nYou got everything!";
            document.getElementById("bob").src = "audio/goodjob.wav";
            document.getElementById("bob").play();
        }, 1600);
        setTimeout(function () {
            window.history.back();
        }, 4000);
        //populateWordlist();
    }
    toastClone.className = "toast show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function () {
        toastClone.className = toastClone.className.replace("show", "");
    }, 3000);
}
