<?php

namespace PostmanImporter;

use Exception;

/**
 * Description of SourceFile
 *
 * @author gustavo-rodriguez
 */
class SourceFile {

    /**
     *
     * @var string 
     */
    protected $baseUrl;

    /**
     *
     * @var string 
     */
    protected $fullName;

    /**
     *
     * @var string 
     */
    protected $name;

    /**
     *
     * @var string 
     */
    protected $extension;

    /**
     *
     * @var array 
     */
    protected $content;
    
    /**
     * 
     * @param string $baseUrl
     * @param string $fullName
     */
    public function __construct($baseUrl, $fullName) {
        $this->baseUrl = $baseUrl;
        $this->fullName = $fullName;
        
        //Load file info
        $this->loadFileInfo($fullName);
        
        //Load file
        $this->load();
    }

    /**
     * 
     * @return string
     */
    public function getBaseUrl() {
        return $this->baseUrl;
    }

    /**
     * 
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
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
    public function getExtension() {
        return $this->extension;
    }

    /**
     * 
     * @return string
     */
    public function getContent() {
        return $this->content;
    }

    /**
     * 
     * @param string $fullName
     * @return string
     */
    protected function loadFileInfo($fullName) {
        $fileParts = explode('.', $fullName);

        $this->extension = array_pop($fileParts);
        $this->name = implode('.', $fileParts);
    }

    /**
     * 
     * @param string $fileName
     * @return array
     */
    protected function load() {
        $this->content = [];

        try {
            //Get file content
            $aux = file_get_contents($this->baseUrl . $this->fullName);

            //Get decoded content
            $this->content = json_decode($aux, true);
        } catch (Exception $exc) {
            //Do nothing
        }
    }

}
