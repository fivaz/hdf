<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 02.10.2018
 * Time: 11:08
 */

class CateLangModel extends LangModel
{
    public function __construct()
    {
        $this->table = "CATE_LANG_TEXT";
        $this->columnId = "CATE_ID";
        parent::__construct();
    }
}