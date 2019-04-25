<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 17:18
 */

class CategoryModel extends MainModel
{
    public function __construct()
    {
        $this->table = "CATEGORY";
        $this->columnId = "CATE_ID";
        $this->langModel = new CateLangModel();
        $this->tableLang = "CATE_LANG_TEXT";
        parent::__construct();
    }

    public function createCategory($cateId, $name, $price, $position, $langId){
        $this->setAttr("CATE_ID", $cateId);
        $this->langModel->setAttr("NAME", $name);
        $this->langModel->setAttr("LANG_ID", $langId);
        $this->setAttr("PRICE", $price);
        $this->setAttr("POSITION", $position);
        return $this->create();
    }

    public function addLang($cateId, $name, $langId){
        $this->langModel->setAttr("CATE_ID", $cateId);
        $this->langModel->setAttr("NAME", $name);
        $this->langModel->setAttr("LANG_ID", $langId);
        return $this->langModel->create();
//        return $this->langModel->update();
    }
}