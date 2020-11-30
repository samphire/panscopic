var courseid, coursedesc, studentid, password;
var ajax;
if (typeof Storage !== "undefined") {
    //Below line has to be set when testing and so on...
    // if (screen.width > 767) {
        localStorage.removeItem("user"); // ALWAYS REMOVE USER TEMPORARILY...
    // }
    if (localStorage.getItem("user")) {
        courseid = localStorage.getItem("course");
        coursedesc = localStorage.getItem("coursedesc");
        studentid = localStorage.getItem("user");
        password = localStorage.getItem("password");
        headForHome();
    }
}


function ajaxCall(method, url, sync) {
    console.log("ajaxCall function called");
    var bob = null;
    ajax = new XMLHttpRequest();
    ajax.open(method, url, sync);
    ajax.onreadystatechange = function () {
        if (ajax.readyState == 4) {
            bob = ajax.responseText;
        }
    };
    ajax.send();
    return bob;
}

function headForHome() {
    //set session variables in ajax
    var resp = ajaxCall("GET", "login.php?courseid=" + courseid + "&coursedesc=" + coursedesc + "&studentid=" + studentid, false);
    console.log(resp);
    // window.location = "home.php";
    window.location = "welcome.php";
}

function handleEnter(e) {
    if (e.keyCode === 13 && e.target.id == "pass2") {
        go(e.target);
        return;
    }

    if (e.keyCode === 13) {
        e.target.blur();
        document.getElementById('spinner').style.display = 'block';
        console.log("pressed Enter on " + e.target.id);
        setTimeout(function () {
            verifyPassword(e.target)
        }, 1000);
    }
}

function setCourse(id, desc, myEl) {
    console.log("setCourse function called");
    courseid = id;
    coursedesc = desc;
    myEl.parentNode.parentNode.classList.remove("on");
    myEl.parentNode.parentNode.classList.add("off");
    myEl.parentNode.parentNode.nextElementSibling.classList.remove("off");
    myEl.parentNode.parentNode.nextElementSibling.classList.add("on");

    var startEl = myEl.parentNode.parentNode.nextElementSibling.firstElementChild;
    var nodeArr = startEl.childNodes;
//                alert("there are " + nodeArr.length + " child nodes\nNow will recurse the children");
//                recurseDomChildren(startEl, true);

    for (var i = 0; i < nodeArr.length; i++) {
        //var el = nodeArr[i];
//                    alert(i+1 + "of " + nodeArr.length + ". " + el.nodeName + ", " + el.nodeType + ", " + el.nodeValue + ", " + el.id);
        if (nodeArr[i].tagName == "DIV" && nodeArr[i].id != "course" + id) {
//                        alert("removing " + nodeArr[i].id);
            nodeArr[i].parentNode.removeChild(nodeArr[i]);
        }
    }
}
function setStudent(mySelect) {
    console.log("setStudent function called");
    studentid = mySelect.value;
    var selected = mySelect.options[mySelect.selectedIndex];
    var setStudentNode = mySelect.parentNode.parentNode.parentNode;
    recurseDomChildren(setStudentNode, true);
    setStudentNode.classList.remove("on");
    setStudentNode.classList.add("off");
    var setPassNode;
    if (selected.classList.contains("noPass")) {
        setPassNode = setStudentNode.nextElementSibling;
        setPassNode.classList.remove("off");
        setPassNode.classList.add("on");
    } else {
        setPassNode = setStudentNode.nextElementSibling.nextElementSibling;
        setPassNode.classList.remove("off");
        setPassNode.classList.add("on");
        //document.getElementById("realPass").setAttribute("onchange", "sendPass(this)");
    }
}

function go(myPass) {
    console.log("function go called");
    if (myPass.value === myPass.previousElementSibling.previousElementSibling.value) {
        password = myPass.value;
        putPasswordToDb();
    } else {
        alert("Passwords do not match. Try again!");
    }
}

function putPasswordToDb() {
    var url = "putPass.php?user=" + studentid + "&course=" + courseid + "&password=" + password;
    console.log(url);
    var responseText = ajaxCall("GET", url, false);
    if (responseText == 'success') {
        setLocalStorage();
        headForHome();
    } else {
        alert('something wrong! Contact 010 4357 2757');
        console.log(responseText);
    }


}
function setLocalStorage() {
    localStorage.setItem("user", studentid);
    localStorage.setItem("course", courseid);
    localStorage.setItem("coursedesc", coursedesc);
    localStorage.setItem("password", password);
}

function verifyPassword(myInput) {
    var url = "verify.php?user=" + studentid + "&password=" + myInput.value;
    console.log("verifyPassword function called\n" + url);
    var responseText = ajaxCall("GET", url, false);
    console.log("response text from sendPass: " + responseText);
    if (responseText == 'success') {
        password = myInput.value;
        setLocalStorage();
        headForHome();
    } else {
        document.getElementById('spinner').style.display = 'none';
        console.log('Dammit! wrong password\n' + responseText);
        alert("wrong password");
    }
}


function recurseDomChildren(start, output) {
    var nodes;
//                console.log("START IS: " + start.tagName + ", " + start.id);
    if (start.childNodes) {
        nodes = start.childNodes;
        loopNodeChildren(nodes, output);
    }
}

function loopNodeChildren(nodes, output) {
    var node;
    for (var i = 0; i < nodes.length; i++) {
        node = nodes[i];
        if (output) {
            outputNode(node);
        }
        if (node.childNodes) {
            recurseDomChildren(node, output);
        }
    }
}

function outputNode(node) {
    var whitespace = /^\s+$/g;
    if (node.nodeType === 1) {
//                    console.log("element: " + node.tagName + ", " + node.id + ", " + node.classList);
    } else if (node.nodeType === 3) {
        //clear whitespace text nodes
        node.data = node.data.replace(whitespace, "");
        if (node.data) {
//                        console.log("text: " + node.data);
        }
    }
}

