var soundsNo = ['no', 'nooo', 'notright', 'notquiteright', 'kidding'];
var soundsYes = ['goodjob', 'ohyeah', 'ugotit', 'welldone', 'yes'];
var hurryup = ['comeon', 'hurryup', 'waitingfor', 'yawn'];
var wordlist = [];

var timer;
var hurrytimer;
var currentItemName;
var currentIndex = 0;
var audio;

window.onload = function () {
    audio = document.getElementById('bob');
    populateWordlist();
    showToast();
}

function populateWordlist() {
    var mySVGString = document.getElementById("container").firstElementChild.innerHTML;
    console.log(mySVGString);
    var patt = /playSprite\('(.*?)'/g;
    var result = mySVGString.match(patt);
    result.forEach(function (item) {
        wordlist.push(item.substring(12, item.length - 1));
    });
    wordlist = Array.from(new Set(wordlist)); // Set in ECMA6 removes duplicates
}

function playSprite(name) {
    const bob = "audio/" + name + ".wav";
    document.getElementById("bob").src = bob;
    document.getElementById("bob").play();
    let idx = wordlist.findIndex(function (value, index) {
        console.log(value);
        return value === name;
    });
    console.log(idx);
    if (idx > -1) {
        wordlist.splice(idx, 1);
    }
    if (wordlist.length < 4) {
        showToast();
    }
}

function doNext() {
    currentItemName = wordlist[currentIndex];
    console.log(currentIndex + ": " + currentItemName);
    if (currentIndex == wordlist.length) {
        alert('the end');
    }
    playSprite(wordlist[currentIndex]);
}

function check(name) {
    console.log('in check');
    if (name == currentItemName) {
        playSprite(soundsYes[Math.floor(Math.random() * soundsYes.length)]);
        currentIndex++;
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

function showToast() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar");
    if (wordlist.length > 0) {
        x.innerText = wordlist.length === 1 ? "There is 1 word to find" : "There are " + wordlist.length + " words to find";
        // Add the "show" class to DIV
    } else {
        setTimeout(function () {
            x.innerText = "Well Done!\nYou got everything!";
            document.getElementById("bob").src = "audio/goodjob.wav";
            document.getElementById("bob").play();
        }, 1600);
        populateWordlist();
    }
    x.className = "show";

    // After 3 seconds, remove the show class from DIV
    setTimeout(function () {
        x.className = x.className.replace("show", "");
    }, 3000);
}