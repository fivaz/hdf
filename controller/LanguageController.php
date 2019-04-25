<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 05.10.2018
 * Time: 10:04
 */

class LanguageController
{
    public $model;

    public function __construct()
    {
        $this->model = new LanguageModel();
    }

    public function loadLanguages()
    {
        $languages = $this->model->select();
        return json_encode($languages);
    }

}