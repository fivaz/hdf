function ajax(link, method, json, callback)
{
    let data;
    $.post(link+method, json, function(dataString)
    {
        // console.log(dataString);
        try{
            data = $.parseJSON(dataString);
            // console.log(data);
        }catch{
            data = dataString;
        }
        if(callback){
            callback(data);
        }
    })
    .fail(function(xhr, status, error)
    {
        console.log("xhr:");
        console.log(xhr);
        console.log("status:");
        console.log(status);
        console.log("error:");
        console.log(error);
    });
}

function buildLanguageSelect(select, cookieName)
{
    let link = "../routes/languageRouting.php?method=";
    let method = "getLanguages";

    ajax(link, method, null, function(languages)
    {
        $.each(languages, function()
        {
            let option;

            if(getCookie(cookieName) == this.LANG_ID)
            {
                option = $("<option selected>");
            }
            else
            {
                option = $("<option>");
            }

            option.text(this.LANGUAGE);
            option.val(this.LANG_ID);
            select.append(option);
        });
    });
}

function getSiteLang()
{
    return $("#siteLanguage").val();
}
/*
*/

function getLang()
{
    return $("#lang").val();
}

function getAdmin()
{
    return $("#admin").val();
}

function loadLang(callback)
{
    let link = "../../routes/languageRouting.php?method=";
    let method = "getSiteLang";
    ajax(link, method, null, function(text)
    {
        lang = text;
        callback();
    });
}
