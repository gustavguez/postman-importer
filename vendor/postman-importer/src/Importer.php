<?php

namespace PostmanImporter;

/**
 * Description of Importer
 *
 * @author gustavo-rodriguez
 */
class Importer {

    /**
     *
     * @var string 
     */
    protected $baseUrl;

    /**
     * 
     * @param string $baseUrl
     */
    function __construct($baseUrl) {
        $this->baseUrl = $baseUrl;
    }
    
    /**
     * Import file based in base url
     */
    public function run() {
        var_dump($this->baseUrl);
    }

}
