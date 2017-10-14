<?php

namespace PostmanImporter\Collection;

/**
 * Description of ItemRequestData
 *
 * @author gustavo-rodriguez
 */
class ItemRequestData {

    //Types
    const BODY_TEXT_TYPE = 'text';

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
    protected $type;

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
    public function getType() {
        return $this->type;
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
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'key' => $this->key,
            'value' => $this->value,
            'type' => self::BODY_TEXT_TYPE
        ];
    }

}
