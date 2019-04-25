<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 02.10.2018
 * Time: 11:08
 */

class MenuLangModel extends LangModel
{
    public function __construct()
    {
        $this->table = "MENU_LANG_TEXT";
        $this->columnId = "MENU_ID";
        parent::__construct();
    }
}