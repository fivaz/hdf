<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 28.09.2018
 * Time: 13:54
 */

class TranslationModel1 extends Model1
{

    public function getColumnId()
    {
        $columns = array_keys($this->attributes);

        foreach ($columns as $column)
        {
            $suffix = substr($column, strlen($column)-3, strlen($column));
            if($suffix == "_ID" AND $column != "LANG_ID")
            {
                return $column;
            }
        }
    }
}