<?php

namespace PostmanImporter\Collection;

/**
 * Description of ItemRequestHeader
 *
 * @author gustavo-rodriguez
 */
class ItemRequestHeader {

    /**
     *
     * @var string 
     */
    protected $key;

    /**
     *
     * @var string 
     */
    protected $value;

    /**
     *
     * @var string 
     */
    protected $description;

    /**
     * 
     * @return string
     */
    public function getKey() {
        return $this->key;
    }

    /**
     * 
     * @return string
     */
    public function getValue() {
        return $this->value;
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
     * @param string $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     * 
     * @param string $value
     */
    public function setValue($value) {
        $this->value = $value;
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
     * @return array
     */
    public function toArray() {
        return [
            'key' => $this->key,
            'value' => $this->value,
            'description' => $this->description
        ];
    }

}
