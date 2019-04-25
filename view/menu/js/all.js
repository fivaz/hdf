function buildLanguageSelectMenu(select, cookieName)
{
    let link = "../../routes/languageRouting.php?method=";
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


function deleteConfirm(callback){
    let form = $("<div class='myModal'>");
        let head = $("<div class='d-flex'>");
            let leftPanel = $("<div class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let rightPanel = $("<div class='head-side'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
        let body = $("<div class='confirm-body container'>");
            let text = $("<p>");
        let footer = $("<div class='myModal-footer'>");
            let btnYes = $("<button class='myBtn'>");

    form.append(head);
        head.append(leftPanel);
        head.append(title);
            title.text(lang.delete_confirm_title);
        head.append(rightPanel);
            rightPanel.append(btnClose);
    form.append(body);
        body.append(text);
            text.text(lang.delete_confirm_text);
    form.append(footer);
        footer.append(btnYes);
            btnYes.text(lang.confirm);

    $("body").append(form);

    btnClose.click(function(){
        form.remove();
    });

    btnYes.click(function(){
        callback();
        form.remove();
    });

}