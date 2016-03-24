

function setHandlers() {
    var buttonTypes = [
        'userlist',
        'studentlist',
        'internshiplist',
        'orglist'
    ];
    console.log(buttonTypes);
    for(var i = 0; i < buttonTypes.length; i++) {
        console.log("trying to get id: " + buttonTypes[i]);
        var temp = document.getElementById(buttonTypes[i]);
        console.log("handler for: " + temp);
        temp.setAttribute("class", "buttonOff");
        temp.addEventListener(function(temp) {
            changeCss(temp);
        }, true);
    }
}

function changeCss(id) {
    console.log("IN CSS" + buttonTypes);
    var button = document.getElementById(id);
    button.setAttribute("class", ".buttonOn");
    for(var i = 0; i < buttonTypes.length; i++) {
        var temp = document.getElementById(buttonTypes[i]);
        if(temp !== id) {
            temp.setAttribute("class", ".buttonOff");
        }
    }
}

