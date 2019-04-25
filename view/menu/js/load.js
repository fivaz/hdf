var lang;

$(document).ready(function()
{
    loadLang(function()
    {
        loadCategories();

        $("#add-article").click(function()
        {
            $(".myModal").remove();
            createArticleForm();
        });

        $("#add-category").click(function()
        {
            $(".myModal").remove();
            createCategoryForm();
        });

        //creer une fonction avec ça et mettez-la dans article.js
        $("#add-article-submit").click(function()
        {
            let inputName = $("#add-article-name");
            let inputPrice = $("#add-article-price");
            let inputDescription = $("#add-article-description");
            let selectCategory = $("#add-article-select");

            let link = "../../controller/routes.php?method=";
            let method = "createArticle";
            let json = {
                name: inputName.val(),
                price: inputPrice.val(),
                description: inputDescription.val(),
                categoryId: selectCategory.val(),
                languageId: getLang()
            };

            $.post(link+method, json, function(articleString)
            {
                console.log(articleString);
                let articleJSON = JSON.parse(articleString);
                console.log(articleJSON);

                let categoryPanel = getCategoryPanel(selectCategory.val());

                assembleArticle(categoryPanel, articleJSON[0]);
            });
        });
    });
});