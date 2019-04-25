<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 28.09.2018
 * Time: 13:54
 */

class LangModel extends Model1
{
    public function update()
    {
        if(!$this->modified){
            return;
        }

        //premiere partie de la query update
        $query = "UPDATE {$this->table} SET ";

        //ajoute chaque colonne et valeur à la query
        foreach ($this->attributes as $key => $value)
        {
            if($value === null)
            {
                $query = $query . $key . " = DEFAULT, ";
            }
            else
            {
                $query = $query.$key." = '".$value."', ";
            }
        }

        //enleve le derniere ", "
        $query = substr($query, 0, strlen($query)-2);

        //ajoute à la fin la condition id = id
        $query = $query." WHERE ".$this->columnId." = ".$this->getId()." AND LANG_ID = ".$this->getAttr("LANG_ID");

        echo $query."</br>";

        $result = $this->connection->exec($query);

        if($result){
            $this->modified = false;
        }

        return $result;
    }

}