<?php

namespace PostmanImporter\Entities;

/**
 * Description of ItemEvent
 *
 * @author gustavo-rodriguez
 */
class ItemEvent {

    /**
     *
     * @var string 
     */
    protected $listen;

    /**
     *
     * @var array 
     */
    protected $script;
    
    /**
     * 
     * @return string
     */
    public function getListen() {
        return $this->listen;
    }
    
    /**
     * 
     * @return array
     */
    public function getScript() {
        return $this->script;
    }
    
    /**
     * 
     * @param string $listen
     */
    public function setListen($listen) {
        $this->listen = $listen;
    }
    
    /**
     * 
     * @param array $script
     */
    public function setScript($script) {
        $this->script = $script;
    }
    
    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'listen' => $this->listen,
            //Map scripts to array
            'script' => array_map(function(ItemEventScript $script) {
                        //return array representation
                        return $script->toArray();
                    }, $this->script),
        ];
    }

}
