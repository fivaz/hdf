function ajaxArticle(method, json, callback)
{
    let link = "../../routes/articleRouting.php?method=";

    let data = "rien reçue";

    console.log("test sync: ");

    console.log("les informations reçues sont: ");

    ajax(link, method, json, function (data) {
        callback(data);
    });

    console.log(data);
}

function getArticles(panel, categoryJSON)
{
    let method = "getArticles";
    let json = {
        languageId: categoryJSON.LANG_ID,
        categoryId: categoryJSON.CATE_ID
    };

    // console.log("get Articles -> langId = "+json.languageId+" and categoryId = "+json.categoryId);

    ajaxArticle(method, json, function(articles){
        /*
        console.log("articles: ");
        console.log(articles);
        */
        $.each(articles, function()
        {
            /*
            console.log("each article: ");
            console.log(this);
            */
            assembleArticle(panel, this);
        });
    });
}

function assembleArticle(panel, articleJSON)
{
    let article = $("<article class='article'>");
        let head = $("<div class='article-head'>");
        let title = $("<h3 class='title'>");
            let rightSide = $("<div class='d-flex'>");
                let price = $("<h3>");
                let currency = $("<h3>&nbsp;CHF</h3>");
                /*outdated*/
                let id = $("<input type='hidden' class='id'>");
                let categoryId = $("<input type='hidden' class='categoryId'>");
                let position = $("<input type='hidden' class='position'>");
                let options = $("<div class='dropdown'>");
                let btnOptions = $("<button class='btn dropdown-toggle p-0' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>");
                    let icon = $("<span class='fa'>&#xf142;</span>");
                    let list = $("<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>");
                        let editArticle = $("<button class='dropdown-item'>");
                        let btnDeleteArticle = $("<button class='dropdown-item'>");
                        let btnHighlight = $("<button class='dropdown-item'>");
                        let btnIngredients = $("<button class='dropdown-item'>");
        let body = $("<div class='article-description'>");
            let description = $("<p>");

    article.append(head);
    article.attr('id', articleJSON.MENU_ID);
    article.attr('position', articleJSON.POSITION);
    article.attr('categoryId', articleJSON.CATE_ID);
        head.append(title);
            title.text(articleJSON.NAME);
        head.append(rightSide);
            rightSide.append(price);
                        price.text(articleJSON.PRICE);
            rightSide.append(currency);
            /*outdated*/
            rightSide.append(id);
                    id.val(articleJSON.MENU_ID);
            rightSide.append(categoryId);
                    categoryId.val(articleJSON.CATE_ID);
            rightSide.append(position);
                    position.val(articleJSON.POSITION);

    if(getAdmin() == 1)
    {
        rightSide.append(options);
            options.append(btnOptions);
                btnOptions.append(icon);
            options.append(list);
                list.append(editArticle);
                    editArticle.text(lang.article_edit);
                list.append(btnDeleteArticle);
                    btnDeleteArticle.text(lang.article_delete);
                list.append(btnHighlight);
                    btnHighlight.text(lang.highlight_on);
                list.append(btnIngredients);
                    btnIngredients.text(lang.ingredients);

        sortArticle();
    }

    article.append(body);
        body.append(description);
            description.text(articleJSON.DESCRIPTION);

    if(articleJSON.ISHIGHLIGHT == "1")
    {
        $("#highlight").append(article);
        article.toggleClass("article_highlight");
        btnHighlight.text(lang.highlight_off);
    }
    else
    {
        panel.append(article);
    }

    btnHighlight.click(function(){
        toggleHighLight(panel, article, articleJSON, $(this));
    });

    editArticle.click(function(){
        editArticleForm(id, title, price, description, categoryId/*, position*/);
    });

    btnDeleteArticle.click(function(){
        deleteConfirm(function()
        {
            deleteArticle(article, id);
        });
    });

    btnIngredients.click(function()
    {
        getIngredientsList(id.val());
    });

    //article.css("order", articleJSON.POSITION);
}

function sortArticle()
{
    $('.articles').sortable(
    {
        connectWith: '.articles',

        activate: function()
        {
            // console.log("dragged");
            $(this).addClass('dragging-box');

            $(this).children().each(function(){
                $(this).addClass('dragging-item');
            });
        },

        deactivate: function()
        {
            // console.log("dropped");
            $(this).removeClass('dragging-box');

            $(this).children().each(function(){
                $(this).removeClass('dragging-item');
            });
        },

        update: function()
        {
            $(this).children().each(function(index)
            {
                let category = $(this).parent().parent().parent();
                /*
                console.log($(this));
                console.log(index+1);
                console.log($(this).attr('position'));

                console.log($(this).attr('categoryId'));
                console.log(category.attr('id'));
                */
                if($(this).attr('position') != (index+1))
                {
                    /*
                    console.log(this);
                    console.log(" has changed!");
                    */
                    updateArticlePosition($(this).attr('id'), index+1);
                    $(this).attr('position', index+1);
                }

                if($(this).attr('categoryId') != category.attr('id'))
                {
                    // console.log("category has been changed!");
                    updateArticleCategory($(this).attr('id'), category.attr('id'));
                    $(this).attr('categoryId', category.attr('id'));
                }
            });
        }
    });
}

function updateArticlePosition(id, newPosition)
{
    let method = "updatePosition";
    let json = {
        articleId : id,
        articleNewPosition : newPosition
    };

    ajaxArticle(method, json, function(result){
        console.log(result);
    });
}

function updateArticleCategory(id, newCategoryId)
{
    let method = "updateCategory";
    let json = {
        articleId : id,
        newCategoryId : newCategoryId
    };

    ajaxArticle(method, json, function(result){
        console.log(result);
    });
}

function toggleHighLight(articlesPanel, article, articleJSON, button)
{
    article.toggleClass("article_highlight");

    if(article.parent()[0] == $("#highlight")[0])
    {
        articlesPanel.append(article);
        button.text(lang.highlight_on);
    }
    else
    {
        $("#highlight").append(article);
        button.text(lang.highlight_off);
    }

    let method = "toggleHighlight";
    let json = {
        articleId : articleJSON.MENU_ID
    };

    ajaxArticle(method, json, function(){});
}

function createArticleForm(categoryId)
{
    let form = $("<div class='myModal'>");
        let head = $("<div class='d-flex'>");
            let leftPanel = $("<div class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let id = $("<input type='hidden'>");
            let rightPanel = $("<div class='head-side'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
        let body = $("<div>");
            let row = $("<label class='d-flex'>");
                let boxName = $("<div class='myModal-80'>");
                    let labelName = $("<label>");
                    let newInputName = $("<input class='myInput' required>");
                let boxPrice = $("<div class='flex-20'>");
                    let labelPrice = $("<label>");
                    let newInputPrice = $("<input class='myInput'>");
            let boxDescription = $("<div>");
                let labelDescription = $("<label>");
                let newInputDescription = $("<textarea class='myInput'>");
            let boxCategory = $("<div>");
                let labelCategory = $("<label>");
                let newSelectCategory = $("<select class='mySelect'>");
        let footer = $("<div class='myModal-footer'>");
            let buttonSubmit = $("<button class='myBtn'>");

    form.append(head);
        head.append(leftPanel);
        head.append(title);
            title.text(lang.article_create);
        head.append(rightPanel);
            rightPanel.append(btnClose);
        head.append(id);
            id.val();
    form.append(body);
        body.append(row);
            row.append(boxName);
                boxName.append(labelName);
                    labelName.text(lang.menu_name);
                boxName.append(newInputName);
            row.append(boxPrice);
                boxPrice.append(labelPrice);
                    labelPrice.text(lang.menu_price);
                boxPrice.append(newInputPrice);
        body.append(boxDescription);
            boxDescription.append(labelDescription);
                labelDescription.text(lang.menu_description);
            boxDescription.append(newInputDescription);
        body.append(boxCategory);
            boxCategory.append(labelCategory);
                labelCategory.append(lang.menu_category);
            boxCategory.append(newSelectCategory);
    form.append(footer);
        footer.append(buttonSubmit);
            buttonSubmit.text(lang.article_create);

    $("body").append(form);

    buildCategoriesSelect(newSelectCategory, categoryId);

    btnClose.click(function(){
        form.remove();
    });

    buttonSubmit.click(function()
    {
        let method = "createArticle";
        let json = {
            name: newInputName.val(),
            price: newInputPrice.val(),
            description: newInputDescription.val(),
            categoryId: newSelectCategory.val(),
            languageId: getLang()
        };

        ajaxArticle(method, json, function(article)
        {
            let categoryPanel = getCategoryPanel(newSelectCategory.val());

            console.log(article);

            assembleArticle(categoryPanel.find('.articles'), article[0]);

            form.remove();
        });
    });
}

function getCategoryPanel(categoryId)
{
    let categories = $(".category");

    let panel = null;

    $.each(categories, function()
    {
        let id = $(this).find(".id");

        if(id.val() == categoryId)
        {
            panel = $(this);
        }
    });

    return panel;
}

function editArticleForm(oldInputId, oldInputName, oldInputPrice, oldInputDescription, oldInputCategoryId/*, oldInputPosition*/)
{
    let categoryChanged = false;
    /**Deprecated*/
    /*
    let orderChanged = false;
    */

    let form = $("<div class='myModal'>");
        let head = $("<div class='d-flex'>");
            let leftPanel = $("<div class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let rightPanel = $("<div class='head-side'>");
                let selectLang = $("<select class='mySelect mr-2'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
            let inputId = $("<input type='hidden'>");
            let inputLangId = $("<input class='langId' type='hidden'>");
        let body = $("<div class='body'>");
            let row1 = $("<div class='d-flex'>");
                let boxName = $("<div class='myModal-80'>");
                    let labelName = $("<label>");
                    let newInputName = $("<input class='myInput' required>");
                let boxPrice = $("<div class='flex-20'>");
                    let labelPrice = $("<label>");
                    let newInputPrice = $("<input class='myInput'>");
            let boxDescription = $("<div>");
                let labelDescription = $("<label>");
                let newInputDescription = $("<textarea class='myInput'>");
            let boxCategory = $("<div>");
                let labelCategory = $("<label>");
                let newSelectCategory = $("<select class='mySelect'>");

            /**Deprecated*/
            /*
            let row2 = $("<div class='d-flex'>");
                let boxCategory = $("<div>");
                    let labelCategory = $("<label>");
                    let newSelectCategory = $("<select class='mySelect'>");
                let boxPosition = $("<div class='flex-20'>");
                    let labelPosition = $("<label>");
                    let newSelectPosition = $("<select class='mySelect'>");
            */

        let footer = $("<div class='myModal-footer'>");
            let buttonSubmit = $("<button class='myBtn'>");

    form.append(head);
        head.append(leftPanel);
        head.append(title);
            title.text(lang.article_edit);
        head.append(rightPanel);
            rightPanel.append(selectLang);
            rightPanel.append(btnClose);
        head.append(inputId);
            inputId.val(oldInputId.val());
        head.append(inputLangId);
            inputLangId.val(getLang());
    form.append(body);
        body.append(row1);
            row1.append(boxName);
                boxName.append(labelName);
                    labelName.text(lang.menu_name);
                boxName.append(newInputName);
                    newInputName.val(oldInputName.text());
            row1.append(boxPrice);
                boxPrice.append(labelPrice);
                    labelPrice.text(lang.menu_price);
                boxPrice.append(newInputPrice);
                    newInputPrice.val(oldInputPrice.text());
        body.append(boxDescription);
            boxDescription.append(labelDescription);
                labelDescription.text(lang.menu_description);
            boxDescription.append(newInputDescription);
                newInputDescription.val(oldInputDescription.text());
        body.append(boxCategory);
            boxCategory.append(labelCategory);
                labelCategory.text(lang.menu_category);
            boxCategory.append(newSelectCategory);

        /**Deprecated*/
        /*
            body.append(row2);
        row2.append(boxCategory);
            boxCategory.append(labelCategory);
                labelCategory.text(lang.menu_category);
            boxCategory.append(newSelectCategory);

        row2.append(boxPosition);
            boxPosition.append(labelPosition);
                labelPosition.append(lang.menu_position);
            boxPosition.append(newSelectPosition);
        */

    form.append(footer);
        footer.append(buttonSubmit);
            buttonSubmit.text(lang.article_edit);

    // console.log(newSelectPosition);

    // buildPositionsSelect(newSelectPosition, oldInputCategoryId.val(), oldInputPosition.val());

    console.log(newSelectCategory);

    buildCategoriesSelect(newSelectCategory, oldInputCategoryId.val());

    $("body").append(form);

    buildLanguageSelectMenu(selectLang, "siteLanguage");

    /**Deprecated*/
    /*
    if(!getCookie("menuLanguage"))
    {
        setCookie("menuLanguage", getCookie("siteLanguage"), 1);
    }
    */

    selectLang.change(function()
    {
        let languageId = $(this).val();
        changeArticleLang(languageId, inputLangId, inputId, newInputName, newInputDescription);
    });


    newSelectCategory.change(function()
    {
        categoryChanged = true;
    });

    /**deprecated*/
    /*
    newSelectPosition.change(function()
    {
        orderChanged = true;
    });
    */

    btnClose.click(function()
    {
        form.remove();
    });

    buttonSubmit.click(function()
    {
        let method = "editArticle";
        let json = {
            name: newInputName.val(),
            price: newInputPrice.val(),
            description: newInputDescription.val(),
            categoryId: newSelectCategory.val(),
            id: inputId.val(),
            languageId: inputLangId.val()
        };

        /*
        console.log("data");
        console.log(newInputName.val());
        console.log(newInputPrice.val());
        console.log(newInputDescription.val());
        console.log(newSelectCategory.val());
        */

        ajaxArticle(method, json, function()
        {
            oldInputPrice.text(newInputPrice.val());
            // oldInputCategoryId.val(newSelectCategory.val());

            if(inputLangId.val() == getLang())
            {
                oldInputName.text(newInputName.val());
                oldInputDescription.text(newInputDescription.val());
            }

            if(categoryChanged){
                swapeCategory(inputId.val(), newSelectCategory.val());
            }

            /**Deprecated*/
            /*
            if(orderChanged){
                swapeOrder(inputId.val(), oldInputPosition.val(), newSelectPosition.val());
            }
            */

            form.remove();
        });
    });
}

/**Deprecated*/
/*
function swapeOrder(articleId, oldPosition, newPosition)
{
    let articles = null;

    let allArticles = $(".article");

    $.each(allArticles, function()
    {
        let articleInputId = $(this).find(".id");

        if(articleInputId.val() == articleId)
        {
            let category = articleInputId.parents(".category");
            articles = category.find(".article");
        }
    });

    $.each(articles, function()
    {
        console.log(this);

        let position = $(this).find(".position").val();

        if(position == oldPosition)
        {
            $(this).find(".position").val(newPosition);
            $(this).css("order", newPosition);
            let article1 = $(this).find(".id");
            setNewPosition(article1.val(), newPosition);
        }

        if(position == newPosition)
        {
            $(this).find(".position").val(oldPosition);
            $(this).css("order", oldPosition);
            let article2 = $(this).find(".id");
            setNewPosition(article2.val(), oldPosition);
        }
    });
}
*/

/**Deprecated*/
/*
function setNewPosition(articleId, newPosition)
{
    let method = "editPosition";
    let json = {
        id: articleId,
        position: newPosition
    };

    ajaxArticle(method,json, function(data){
        console.log(data);
    });
}
*/

function changeArticleLang(newLangId, oldInputLangId, inputId, inputName, inputDescription)
{
    /**Deprecated*/
    //setCookie("menuLanguage", newLangId, 1);

    let method = "changeLanguage";
    let json = {
        newLanguageId: newLangId,
        oldLanguageId: oldInputLangId.val(),
        id: inputId.val(),
    };
    ajaxArticle(method, json, function(article)
    {
        console.log("article:");
        console.log(article[0]);
        inputName.val(article[0].NAME);
        inputDescription.val(article[0].DESCRIPTION);
        oldInputLangId.val(article[0].LANG_ID);
    });
}

function swapeCategory(articleId, categoryId)
{
    console.log(categoryId);

    let newCategory;

    let categories = $(".category");

    $.each(categories, function()
    {
        let thisCategoryId = $(this).find(".id");

        if(thisCategoryId.val() == categoryId)
        {
            newCategory = $(this).find(".articles");
        }
    });

    let articles = $(".article");

    $.each(articles, function()
    {
        let thisArticleId = $(this).find(".id");

        if(thisArticleId.val() == articleId)
        {
            newCategory.append(this);
        }
    });
}

function deleteArticle(panel, inputId)
{
    let method = "deleteArticle";
    let json = {
        id: inputId.val()
    };

    ajaxArticle(method, json, function(){
        panel.remove();
    });
}

/**Deprecated*/
/*
function buildPositionsSelect(select, categoryId, positionId)
{
    let method = "getArticles";
    let json = {
        languageId: getLang(),
        categoryId: categoryId
    };

    ajaxArticle(method, json, function(categories)
    {
        $.each(categories, function()
        {
            let option;

            if(positionId == this.POSITION)
            {
                option = $("<option selected>");
            }
            else
            {
                option = $("<option>");
            }

            option.text(this.POSITION);
            option.val(this.POSITION);

            select.append(option);
        });
    });
}
*/

function getIngredientsList(articleId)
{
    let link = "../../routes/ingredientRouting.php?method=";

    let method = "getIngredients";

    let json = {
        languageId : getLang(),
        articleId : articleId
    };

    ajax(link, method, json, function(ingredients){
        showIngredientsList(ingredients, articleId);
    });
}

function showIngredientsList(ingredients, articleId)
{
    let list = $("<div class='myModal'>");
        let header = $("<div class='d-flex'>");
            let leftHeader = $("<div class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let rightHeader = $("<div class='head-side'>");
                let inputArticleId = $("<input type='hidden'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
        let body = $("<div>");
            let inputIngredient = $("<input class='myInput mt-2 mb-0'>");
            let autoComplete = $("<div class='auto-complete'>");

    list.append(header);
        header.append(leftHeader);
        header.append(title);
            title.append(lang.list_of_ingredients);
        header.append(rightHeader);
            rightHeader.append(inputArticleId);
                inputArticleId.val(articleId);
            rightHeader.append(btnClose);
        list.append(body);
        body.append(inputIngredient);
        body.append(autoComplete);

    $.each(ingredients, function() {
        assembleIngredient(body, this);
    });

    $("body").append(list);

    btnClose.click(function(){
        list.remove();
    });

    inputIngredient.keyup(function()
    {
        // console.log(inputIngredient.val());
        assembleAutoComplete(inputIngredient.val(), autoComplete, inputArticleId.val(), body);
    });
}

function assembleIngredient(panel, ingredient)
{
    let ingredientPanel = $("<div class='d-flex mb-2'>");
        let title = $("<div class='flex-100'>");
        let id = $("<input type='hidden'>");
        let articleId = $("<input type='hidden'>");
        let btnDelete = $("<button class='fa'>&#xf00d;</button>");

    panel.append(ingredientPanel);

    ingredientPanel.append(title);
        title.append(ingredient.NAME);
    ingredientPanel.append(id);
        id.val(ingredient.INGR_ID);
    ingredientPanel.append(articleId);
        articleId.val(ingredient.MENU_ID);
    ingredientPanel.append(btnDelete);

    btnDelete.click(function()
    {
        detachIngredient(id, articleId, ingredientPanel);
    });

}

function detachIngredient(inputIngredientId, inputArticleId, ingredientPanel)
{
    let link = "../../routes/ingredientRouting.php?method=";

    let method = "detachIngredient";

    let json = {
        ingredientId : inputIngredientId.val(),
        articleId : inputArticleId.val()
    };

    ajax(link, method, json, function(){
        ingredientPanel.remove();
    });
}

function assembleAutoComplete(ingredientName, autoCompletePanel, articleId, panel)
{
    let link = "../../routes/ingredientRouting.php?method=";

    let method = "getIngredientsByName";

    let json = {
        ingredientName : ingredientName,
        languageId : getLang()
    };

    ajax(link, method, json, function(ingredients)
    {
        autoCompletePanel.empty();
        $.each(ingredients, function()
        {
            fillIngredientBox(articleId, this, autoCompletePanel, panel);
        });
    });
}

function fillIngredientBox(articleId, ingredient, autoCompletePanel, panel)
{

    let ingredientBox = $("<div class='auto-complete-element'>");
    ingredientBox.text(ingredient.NAME);
    autoCompletePanel.append(ingredientBox);

    ingredientBox.click(function()
    {
        attachIngredient(articleId, ingredient, autoCompletePanel, panel);
    });
}

function attachIngredient(articleId, ingredient, autoCompletePanel, panel)
{
    console.log(ingredient);

    let link = "../../routes/ingredientRouting.php?method=";

    let method = "attachIngredient";

    let json = {
        articleId : articleId,
        ingredientId : ingredient.INGR_ID
    };

    ajax(link, method, json, function(data){
        console.log(data);
        autoCompletePanel.empty();
        assembleIngredient(panel, ingredient);
    });

}
