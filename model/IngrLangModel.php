<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 02.10.2018
 * Time: 11:08
 */

class IngrLangModel extends LangModel
{
    public function __construct()
    {
        $this->table = "INGR_LANG_TEXT";
        $this->columnId = "INGR_ID";
        parent::__construct();
    }
}