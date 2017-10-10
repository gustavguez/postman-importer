<?php

namespace PostmanImporter\Entities;

/**
 * Description of Collection
 *
 * @author gustavo-rodriguez
 */
class Collection {

    /**
     *
     * @var string 
     */
    protected $name;
    
    /**
     *
     * @var string 
     */
    protected $postmanId;
    
    /**
     *
     * @var string
     */
    protected $description;
    
    /**
     *
     * @var string 
     */
    protected $schema;
    
    /**
     * 
     * @param string $name
     * @param string $description
     */
    function __construct($name, $description) {
        $this->name = $name;
        $this->description = $description;
        
        //Autoload id and schema
        $this->postmanId = md5($name);
        $this->schema = 'https://schema.getpostman.com/json/collection/v2.0.0/collection.json';
    }
    
    /**
     * 
     * @return boolean
     */
    public function writeToDisk(){
        
        return true;
    }
}
