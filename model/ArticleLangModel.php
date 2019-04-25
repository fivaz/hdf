<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 28.09.2018
 * Time: 13:31
 */

class ArticleLangModel extends TranslationModel1
{
    public function __construct($id = null)
    {
        $this->table = "MENU_LANG_TEXT";
        parent::__construct($id);
    }
}