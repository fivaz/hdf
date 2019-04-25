<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 17:59
 */

class LanguageModel extends MainModel
{
    public function __construct()
    {
        $this->table = "LANGUAGE";
        $this->columnId = "LANG_ID";
        parent::__construct();
    }
}