<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 04.10.2018
 * Time: 17:18
 */

class Model1
{
    public $connection;
    public $table;
    public $columnId;
    protected $attributes;
    protected $modified;

    public function __construct()
    {
        $this->connection = Connection::getConnection();
        $this->startAttrs();
        $this->modified = false;
    }

    public function startAttrs()
    {
        $query = "DESCRIBE {$this->table}";
        $resultsSQL = $this->connection->query($query);
        $resultsPHP = $resultsSQL->fetchAll();
        foreach ($resultsPHP as $result){
            $this->attributes[$result[0]] = null;
        }
    }

    public function filterResult($resultPHP)
    {
        $resultAttrs = array();
        foreach ($resultPHP as $key => $value){
            if(gettype($key) == "string"){
                $resultAttrs[$key] = $value;
            }
        }
        return $resultAttrs;
    }

    public function filterResults($resultsPHP){
        $resultsAttrs = array();

        foreach ($resultsPHP as $resultPHP){
            array_push($resultsAttrs, $this->filterResult($resultPHP));
        }

        return $resultsAttrs;
    }

    public function getId()
    {
        return $this->attributes[$this->columnId];
    }

    public function getAttr($key){
        return $this->attributes[$key];
    }

    public function setAttr($key, $value)
    {
        if($this->getAttr($key) != $value)
        {
            $this->attributes[$key] = $value;
            $this->modified = true;
        }
    }

    public function setAttrs($attributes)
    {
        $this->attributes = $attributes;
    }

    /*SQL Functions*/
    public function select($column = null, $value = null)
    {
        $query = "SELECT * FROM {$this->table}";

        if($column){
            $query .= " WHERE {$column} = {$value}";
        }

        $elementsSQL = $this->connection->query($query);

        $elements = $elementsSQL->fetchAll();

        return $this->filterResults($elements);
    }

    public function find($id)
    {
        $elements = $this->select($this->columnId, $id);

        foreach ($elements as $element)
        {
            $this->setAttrs($element);

            return $this;
        }
    }

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
            if($value === null OR $value == "")
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
        $query = $query." WHERE ".$this->columnId." = ".$this->getId();

//        echo $query."</br>";

        $result = $this->connection->exec($query);

        if($result){
            $this->modified = false;
        }

        return $result;
    }

    public function create()
    {
        //premiere partie de la query update
        $query = "INSERT INTO {$this->table} VALUES(";

        //ajoute chaque colonne et valeur à la query
        foreach ($this->attributes as $value)
        {
            if($value === null)
            {
                $query = $query." DEFAULT, ";
            }
            else
            {
                $query = $query." '".$value."', ";
            }
        }

        //enleve le derniere ", "
        $query = substr($query, 0, strlen($query)-2);

        //ferme le parantèse
        $query = $query.")";

//        echo $query."</br>";

        $this->connection->exec($query);

        $id = $this->connection->lastInsertId();

        return $this->find($id);
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE {$this->columnId} = {$id}";
        return $this->connection->exec($query);
    }

    public function deleteAll()
    {
        $query = "DELETE FROM {$this->table}";

//        echo $query."</br>";

        return $this->connection->exec($query);
    }

}