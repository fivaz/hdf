<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 28.09.2018
 * Time: 10:58
 */

class MainModel extends Model1
{

    public $langModel;
    public $tableLang;

    public function selectJoin($languageId, $value = null, $column = null)
    {
        $query = "SELECT * FROM {$this->table} 
        JOIN {$this->tableLang} 
        ON {$this->table}.{$this->columnId} = {$this->tableLang}.{$this->columnId} 
        AND {$this->tableLang}.LANG_ID = {$languageId}";

        if($value){

            if(!$column){
                $column = $this->columnId;
            }

            $query .= " WHERE {$this->table}.{$column} = {$value}";
        }

        $elementsSQL = $this->connection->query($query);

        $elements = $elementsSQL->fetchAll();

        return $this->filterResults($elements);
    }

    public function selectJoinOrdered($languageId, $value = null, $column = null)
    {
        $query = "SELECT * FROM {$this->table} 
        JOIN {$this->tableLang} 
        ON {$this->table}.{$this->columnId} = {$this->tableLang}.{$this->columnId} 
        AND {$this->tableLang}.LANG_ID = {$languageId}";

        if($value)
        {
            if(!$column)
            {
                $column = $this->columnId;
            }

            $query .= " WHERE {$this->table}.{$column} = {$value}";
        }

        $query .= " ORDER BY {$this->table}.POSITION";

        $elementsSQL = $this->connection->query($query);

        $elements = $elementsSQL->fetchAll();

        $elementsFiltered = $this->filterResults($elements);

        /*
        if($this->table == ""){
            echo $query."\n\n";

            var_dump($elementsFiltered);

            echo "test:  ".json_encode($elementsFiltered);
        }
        */

        return $elementsFiltered;
    }

    public function getNextPosition($parent = null, $value = null)
    {
        $query = "SELECT * FROM {$this->table}";

        if($parent)
        {
            $query .= " WHERE {$parent} = {$value}";
        }

        $query .= " ORDER BY POSITION DESC";

        $lastElementSQL = $this->connection->query($query);

        $lastElement = $lastElementSQL->fetchAll();

        if($lastElement)
        {
            return $lastElement[0]['POSITION'] + 1;
        }
        else
        {
            return 1;
        }
    }

    public function create()
    {
        $results = array();

        $result = parent::create();

        array_push($results, $result);

        $this->langModel->setAttr($this->columnId, $this->getId());

        $result = $this->langModel->create();

        array_push($results, $result);

        return $results;
    }

    public function update()
    {
        $results = array();

        $result = parent::update();

        array_push($results, $result);

        $result = $this->langModel->update();

        array_push($results, $result);

        return $results;
    }

    public function deleteAll()
    {
        $results = array();
        $result = $this->langModel->deleteAll();
        array_push($results, $result);
        $result = parent::deleteAll();
        array_push($results, $result);
        var_dump($results);
        return $results;
    }

}