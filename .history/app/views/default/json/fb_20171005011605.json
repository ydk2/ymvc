<?php $login = $this->newController("/App/Controllers/JSON/FB",$this->model);?> <
!DOCTYPE html >
    <
    html lang = "en" >

    <
    head >
    <
    title > < /title> <
    meta charset = "UTF-8" >
    <
    meta name = "viewport"
content = "width=device-width, height=device-height, initial-scale=1, minimum-scale=1, user-scalable=0" >
    <!-- -->
    <
    /head>

<
body >
    <
    div id = "wrapper" > ... < /div> <
    script >
    //var access_token = location.href.match(/access_token=(.*)$/)[1].split('&expires_in')[0];
    //window.addEventListener('loadstart', function (location) {

    if (location.href.indexOf("access_token") !== -1) {
        // Success
        var access_token = location.href.match(/access_token=(.*)$/)[1].split('&expires_in')[0];
        //localStorage.setItem('facebook_accessToken', access_token);
        //fbuser();
        if (access_token) {
            window.opener.postMessage({ "error": 0, "token": access_token }, "*");
        } else {
            window.opener.postMessage({ "error": 402 }, "*");
        }
        window.close();
    }

if (location.href.indexOf("error_reason=user_denied") !== -1) {
    // User denied
    //userDenied = true;
    //localStorage.setItem('facebook_accessToken', null);
    window.opener.postMessage({ "error": 430 }, "*");
    window.close();
}
//});
//alert(access_token);
//window.opener.localStorage.setItem('facebook_accessToken', access_token);
//if (access_token) {
//window.opener.postMessage({ "token": access_token }, "*");
//}

setTimeout(function() {
    //location.href = 'https://truckdriver.eu/support/fb-callback.php?token='+access_token;
    window.close();
}, 200); <
/script> <
/body>

<
/html>