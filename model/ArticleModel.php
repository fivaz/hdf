<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 17:59
 */

class ArticleModel extends MainModel
{
    public function __construct()
    {
        $this->table = "MENU_ARTICLE";
        $this->columnId = "MENU_ID";
        $this->langModel = new MenuLangModel();
        $this->tableLang = "MENU_LANG_TEXT";
        parent::__construct();
    }

    public function createArticle($articleId, $cateId, $name, $description, $price, $isHighLight, $highLightPrice, $position, $isActive, $lang){
        $this->setAttr("MENU_ID", $articleId);
        $this->setAttr("CATE_ID", $cateId);
        $this->langModel->setAttr("NAME", $name);
        $this->langModel->setAttr("DESCRIPTION", $description);
        $this->langModel->setAttr("LANG_ID", $lang);
        $this->setAttr("PRICE", $price);
        $this->setAttr("ISHIGHLIGHT", $isHighLight);
        $this->setAttr("HIGHLIGHT_PRICE", $highLightPrice);
        $this->setAttr("POSITION", $position);
        $this->setAttr("ISACTIVE", $isActive);
        return $this->create();
    }

    public function addLang($articleId, $name, $description, $langId){
        $this->langModel->setAttr("MENU_ID", $articleId);
        $this->langModel->setAttr("NAME", $name);
        $this->langModel->setAttr("DESCRIPTION", $description);
        $this->langModel->setAttr("LANG_ID", $langId);
        $this->langModel->create();
    }

    /*Deprecated*/
    /*
    public function getNextPosition($categoryId){
        $resultSQL = $this->connection->query("SELECT * FROM MENU_ARTICLE WHERE CATE_ID = {$categoryId} ORDER BY POSITION LIMIT 1");
        $result = $resultSQL->fetchAll();
        return $result;
    }
    */

}