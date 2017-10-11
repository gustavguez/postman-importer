<?php

namespace PostmanImporter\Entities;

/**
 * Description of ItemEventScript
 *
 * @author gustavo-rodriguez
 */
class ItemEventScript {

    /**
     *
     * @var string 
     */
    protected $type;

    /**
     *
     * @var array 
     */
    protected $exec;
    
    /**
     * 
     * @return string
     */
    public function getType() {
        return $this->type;
    }
    
    /**
     * 
     * @return array
     */
    public function getExec() {
        return $this->exec;
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
     * @param array $exec
     */
    public function setExec($exec) {
        $this->exec = $exec;
    }
    
    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'type' => $this->type,
            'exec' => $this->exec
        ];
    }
}
