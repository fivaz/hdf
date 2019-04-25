<?php
/**
 * Created by PhpStorm.
 * User: PONTES_STEFANE-ESIG
 * Date: 28.09.2018
 * Time: 10:58
 */

class TranslableModel1 extends Model1
{
    protected $children;
    protected $parent;

    public function getChildren()
    {
        return $this->children;
    }

    public function find($id)
    {
        parent::find($id);

        $this->findChildren();

        return $this;

    }

    public function findChildren(){
        $child = $this->children[0];

        $query = "SELECT * FROM {$child->table} WHERE {$child->getColumnId()} = {$this->getId()}";

        $childrenSQL = $this->connection->query($query);

        $childrenPHP = $childrenSQL->fetchAll();

        $this->children = array();

        foreach ($childrenPHP as $childPHP)
        {
            $className = get_class($child);

            $newChild = new $className();

            $newChild->setAttrs($childPHP);

            array_push($this->children, $newChild);
        }
    }

    public function getLang($id)
    {
        foreach ($this->children as $child){
            if($child->getAttr("LANG_ID") == $id){
                return $child;
            }
        }
    }

    public function getChild()
    {
        $className = get_class($this->children[0]);
        $child = new $className();
        $child->setAttr($child->getColumnId(), $this->getId());
        return $child;
    }

    public function update(){
        $results = array();
        array_push($results, parent::update());

        foreach ($this->children as $child){
            //if($child->modified){
                array_push($results, $child->update());
            //}
        }
        return $results;
    }

    public function deleteCascade($id = null)
    {
        $results = array();
        if($id)
        {
            $this->find($id);
        }
        array_push($results, $this->deleteChildren());
        array_push($results, $this->delete());

        return $results;
    }

    public function deleteChildren(){
        $results = array();
        foreach($this->children as $child){
            array_push($results, $child->delete());
        }
        return $results;
    }

    public function getAllAttrs($languageId){
        $child = $this->getLang($languageId);
        return array_merge($this->getAttrs(), $child->getAttrs());
    }

    public function allArray($languageId){
        $elementsArray = array();

        foreach($this->all() as $elementModel) {
            array_push($elementsArray, $elementModel->getAllAttrs($languageId));
        }

        return $elementsArray;
    }

    public function allJSON($languageId){
        $elementsModel = $this->allArray($languageId);
        return json_encode($elementsModel);
    }

    public function allBy($parentId)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$this->parent} = {$parentId}";

        $elementsSQL = $this->connection->query($query);

        $elementsPHP = $elementsSQL->fetchAll();

        $elementsModel = array();

        foreach($elementsPHP as $elementPHP){

            $elementModel = new static();

            $elementModel->find($elementPHP[0]);

            array_push($elementsModel, $elementModel);
        }

        return $elementsModel;
    }

    public function ModeltoArray($elementsModel, $languageId)
    {
        $elementsArray = array();

        foreach($elementsModel as $elementModel) {
            array_push($elementsArray, $elementModel->getAllAttrs($languageId));
        }

        return $elementsArray;
    }



}