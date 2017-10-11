<?php

namespace PostmanImporter\Entities;

/**
 * Description of Collection
 *
 * @author gustavo-rodriguez
 */
class Collection {

    const EXTENSION = 'json';

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
     * @var array 
     */
    protected $variables;

    /**
     *
     * @var array
     */
    protected $items;

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
        $this->schema = 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json';
        $this->variables = [];
        $this->items = [];
    }

    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @return array
     */
    public function getVariables() {
        return $this->variables;
    }

    /**
     * 
     * @return array
     */
    public function getItems() {
        return $this->items;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @return string
     */
    public function getPostmanId() {
        return $this->postmanId;
    }

    /**
     * 
     * @return string
     */
    public function getSchema() {
        return $this->schema;
    }

    /**
     * 
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @param array $variables
     */
    public function setVariables($variables) {
        $this->variables = $variables;
    }

    /**
     * 
     * @param array $items
     */
    public function setItems($items) {
        $this->items = $items;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'info' => [
                'name' => $this->name,
                'description' => $this->description,
                '_postman_id' => $this->postmanId,
                'schema' => $this->schema,
            ],
            'variables' => $this->variables,
            //Map items to array
            'items' => array_map(function(Item $item) {
                        //return array representation
                        return $item->toArray();
                    }, $this->items),
        ];
    }

}
