window.onload = function () {
    var anchors = document.getElementsByTagName('a');

    for(var i = 0; i < anchors.length; i++){
        anchors[i].addEventListener('click',AnchorClick);
    }
};

function AnchorClick(){
    var action = this.getAttribute('data-url');
    history.pushState('', '', action);
    Request(action,{},'content');
}

function Request(url,data,viewAreaID){
    var xhr = (typeof new XMLHttpRequest() != 'undefined') ? new XMLHttpRequest : new ActiveXObject("Microsoft.XMLHTTP");

    xhr.onreadystatechange = function () {
        document.getElementById(viewAreaID).innerHTML = xhr.responseText;
    };

    xhr.onloadstart = function () {
        document.getElementById(viewAreaID).innerHTML = '<i class="fa fa-spinner fa-spin fa-2x"></i>';
    };

    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send('send_data='+JSON.stringify(data));
}

window.onpopstate = function () {
    history.pushState()
};
