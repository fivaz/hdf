/*
* Google ReCaptcha loading jscript: requires #recaptcha div and #submitButton
* Author: Frank Théodoloz
* Date: 14/10/2018
* Time: 18:33
*/

var onloadCallback = function () {
    grecaptcha.render('g-recaptcha', {
        'sitekey': '6LduMXMUAAAAALk71O_0Ch6DnLMPPQKa60mAVG6q',
        'theme': 'dark',
        'callback': 'enableButton',
        'expired-callback': 'disableButton'
    });
    disableButton();
};

function enableButton() {
    document.getElementById('submitButton').disabled = false;
}

function disableButton() {
    document.getElementById('submitButton').disabled = true;
}