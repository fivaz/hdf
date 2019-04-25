function ajaxCategory(method, json, callback)
{
    let link = "../../routes/categoryRouting.php?method=";

    ajax(link, method, json, function(data){
       callback(data);
    });
}

function loadCategories()
{
    let method = "getCategories";
    let json = {
        languageId: getLang()
    };

    ajaxCategory(method, json, function(categoriesJSON){
        $.each(categoriesJSON, function(){
            // console.log("category");
            // console.log(this);
            assembleCategory(this, true);
        });
    });
}

function assembleCategory(categoryJSON, loading)
{
    let category = $("<section class='category'>");
        let head = $("<div class='category-head'>");
            let title = $("<h2>");
            let rightSide = $("<div class='d-flex'>");
                let price = $("<h2>");
                let currency = $("<h2>&nbsp;CHF</h2>");
                /*outdated*/
                let id = $("<input class='id' type='hidden'>");
                let position = $("<input class='position' type='hidden'>");

                let options = $("<div class='dropdown'>");
                    let btnOptions = $("<button class='btn dropdown-toggle p-0' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>");
                        let icon = $("<i class='fa'>&#xf142;</i>");
                    let list = $("<div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>");
                        let createArticle = $("<button class='dropdown-item'>");
                        let editCategory = $("<button class='dropdown-item'>");
                        let btnDeleteCategory = $("<button class='dropdown-item'>");

        let body = $("<div>");
            let articles = $("<div class='articles'>");

    category.append(head);
    category.attr('id', categoryJSON.CATE_ID);
    category.attr('position', categoryJSON.POSITION);

        head.append(title);
            // title.text(categoryJSON.NAME);
        head.append(rightSide);
            rightSide.append(price);
                price.text(categoryJSON.PRICE);
            /*outdated*/
            rightSide.append(id);
                id.val(categoryJSON.CATE_ID);
            rightSide.append(position);
                position.val(categoryJSON.POSITION);
            rightSide.append(options);

        if(getAdmin() == 1)
        {
            options.append(btnOptions);
                btnOptions.append(icon);
            options.append(list);
                list.append(createArticle);
                    createArticle.text(lang.article_create);
                list.append(editCategory);
                    editCategory.text(lang.category_edit);
                list.append(btnDeleteCategory);
                    btnDeleteCategory.text(lang.category_delete);

            sortCategory();
        }

        if(categoryJSON.PRICE){
            price.after(currency);
        }

    category.append(body);
        body.append(articles);

    $("#categories").append(category);

    fillTitle(title, categoryJSON.NAME);

    if(loading)
    {
        getArticles(articles, categoryJSON);
    }

    createArticle.click(function()
    {
        createArticleForm(id.val());
    });

    editCategory.click(function()
    {
        editCategoryForm(id, title, price);
    });

    btnDeleteCategory.click(function()
    {
        deleteConfirm(function()
        {
            deleteCategory(category, id);
        });
    });
}

function sortCategory()
{
    $("#categories").sortable(
    {
        activate: function()
        {
            // console.log("dragged");
            $(this).addClass('dragging-box');
            // ui.item.addClass('dragged-item');

            $(this).children().each(function()
            {
                $(this).addClass('dragging-item');
            });
        },

        deactivate: function()
        {
            // console.log("dropped");
            $(this).removeClass('dragging-box');
            // ui.item.removeClass('dragged-item');

            $(this).children().each(function()
            {
                $(this).removeClass('dragging-item');
            });
        },

        update: function()
        {
            // console.log($(this));
            $(this).children().each(function(index)
            {
                // console.log(index+1);
                // console.log($(this).attr('position'));
                if(index+1 != $(this).attr('position'))
                {
                    updateCategoryPosition($(this).attr('id'), index+1);
                    $(this).attr('position', index+1);
                }
            });
        }
    });
}

function updateCategoryPosition(id, newPosition)
{
    let method = "updatePosition";
    let json = {
        id: id,
        newPosition: newPosition
    };

    console.log(json);

    ajaxCategory(method, json, function(result)
    {
        console.log(result);
    });
}

function fillTitle(text, categoryName)
{
    let prefix = categoryName.substr(0, 3);

    if(prefix == "THE"){
        let prefixSpan = $("<span class='font-normal'>");
        prefixSpan.text(prefix);

        let sufix = categoryName.substr(3, categoryName.length);

        let sufixSpan = $("<span class='font-yellow'>");
        sufixSpan.text(sufix);

        text.append(prefixSpan);
        text.append(sufixSpan);
    }else{
        text.text(categoryName);
    }
}

function createCategoryForm()
{
    let form = $("<div class='myModal'>");
        let head = $("<div class='d-flex'>");
            let leftSide = $("<h2 class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let rightSide = $("<div class='head-side'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
            let newInputId = $("<input class='id' type='hidden'>");
        let body = $("<div>");
            let row = $("<div class='d-flex'>");
                let boxName = $("<div class='myModal-80'>");
                    let labelName = $("<label>");
                    let newInputName = $("<input class='myInput' required>");
                let boxPrice = $("<div class='flex-20'>");
                    let labelPrice = $("<label>");
                    let newInputPrice = $("<input class='myInput'>");
        let footer = $("<div class='myModal-footer'>");
            let buttonSubmit = $("<button class='myBtn'>");

    form.append(head);
        head.append(leftSide);
        head.append(title);
            title.text(lang.category_create);
        head.append(rightSide);
            rightSide.append(btnClose);
        head.append(newInputId);
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
    form.append(footer);
        footer.append(buttonSubmit);
            buttonSubmit.text(lang.category_create);

    $("body").append(form);

    btnClose.click(function()
    {
        form.remove();
    });

    buttonSubmit.click(function()
    {
        let method = "createCategory";
        let json = {
            name: newInputName.val(),
            price: newInputPrice.val(),
            languageId: getLang()
        };

        ajaxCategory(method, json, function(article)
        {
            assembleCategory(article[0]);

            form.remove();
        });
    });
}

function editCategoryForm(oldInputId, oldInputName, oldInputPrice)
{
    let form = $("<div class='myModal'>");
        let head = $("<div class='d-flex'>");
            let leftSide = $("<h2 class='head-side'>");
            let title = $("<h2 class='head-title'>");
            let rightSide = $("<div class='head-side'>");
                let selectLang = $("<select class='mySelect mr-2'>");
                let btnClose = $("<button class='myBtn fa'>&#xf00d;</button>");
            let newInputId = $("<input class='id' type='hidden'>");
            let newInputLangId = $("<input class='langId' type='hidden'>");
        let body = $("<div class='body'>");
            let row = $("<div class='d-flex'>");
                let boxName = $("<div class='myModal-80'>");
                    let labelName = $("<label>");
                    let newInputName = $("<input class='myInput' required>");
                let boxPrice = $("<div class='flex-20'>");
                    let labelPrice = $("<label>");
                    let newInputPrice = $("<input class='myInput'>");
        let footer = $("<div class='myModal-footer'>");
            let buttonSubmit = $("<button class='myBtn'>");

    form.append(head);
        head.append(leftSide);
        head.append(title);
            title.text(lang.category_edit);
        head.append(rightSide);
            rightSide.append(selectLang);
            rightSide.append(btnClose);
        head.append(newInputId);
                newInputId.val(oldInputId.val());
        head.append(newInputLangId);
                newInputLangId.val(getLang());
    form.append(body);
        body.append(row);
            row.append(boxName);
                boxName.append(labelName);
                    labelName.text(lang.menu_name);
                boxName.append(newInputName);
                    newInputName.val(oldInputName.text());
            row.append(boxPrice);
                boxPrice.append(labelPrice);
                    labelPrice.text(lang.menu_price);
                boxPrice.append(newInputPrice);
                    newInputPrice.val(oldInputPrice.text());
    form.append(footer);
        footer.append(buttonSubmit);
            buttonSubmit.text(lang.save);

    $("body").append(form);

    buildLanguageSelectMenu(selectLang, "siteLanguage");

    /*
    if(!getCookie("menuLanguage"))
    {
        setCookie("menuLanguage", getCookie("siteLanguage"), 1);
    }
    */

    selectLang.change(function()
    {
        let languageId = $(this).val();
        changeCategoryLang(languageId, newInputLangId, newInputId, newInputName);
    });

    buttonSubmit.click(function()
    {
        let method = "editCategory";
        let json = {
            name: newInputName.val(),
            price: newInputPrice.val(),
            id: newInputId.val(),
            languageId: newInputLangId.val()
        };

        ajaxCategory(method, json, function()
        {
            oldInputPrice.text(newInputPrice.val());

            if(newInputLangId.val() == getLang())
            {
                oldInputName.text("");
                fillTitle(oldInputName, newInputName.val());
                // oldInputName.text(newInputName.val());
            }
            form.remove();
        });
    });

    btnClose.click(function(){
        form.remove();
    });
}

function changeCategoryLang(newLangId, oldInputLangId, inputId, inputName)
{
    setCookie("menuLanguage", newLangId, 1);

    let method = "changeLanguage";
    let json = {
      newLanguageId: newLangId,
      //oldLanguageId: oldInputLangId.val(),
      id: inputId.val(),
    };
    ajaxCategory(method, json, function(category)
    {
        inputName.val(category[0].NAME);
        oldInputLangId.val(category[0].LANG_ID);
    });
}

function deleteCategory(panel, inputId)
{
    let method = "deleteCategory";
    let json = {
        id: inputId.val()
    };

    ajaxCategory(method, json, function(){
        panel.remove();
    });
}

function buildCategoriesSelect(select, categoryId)
{
    let method = "getCategories";
    let json = {
        languageId: getLang()
    };

    ajaxCategory(method, json, function(categoriesJSON){
        $.each(categoriesJSON, function(){
            let option;
            if(categoryId == this.CATE_ID)
            {
                option = $("<option selected>");
            }
            else
            {
                option = $("<option>");
            }
            option.text(this.NAME);
            option.val(this.CATE_ID);
            select.append(option);
        });
    });
}
