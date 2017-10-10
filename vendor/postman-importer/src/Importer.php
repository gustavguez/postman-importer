<?php

namespace PostmanImporter;

use PostmanImporter\Entities\Collection;

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
        $result = [];

        //Control directory
        if (is_dir($this->baseUrl)) {

            //Read files
            $files = scandir($this->baseUrl);

            //Control scandir resturn
            if (is_array($files) && count($files)) {
                foreach ($files as $file) {
                    //Get file extension
                    $fileExtension = $this->getFileExtension($file);

                    //Get importer strategy
                    $strategy = ImporterStrategyFactory::create($fileExtension);

                    //Check strategy
                    if ($strategy instanceof ImporterStrategyInterface) {
                        //Import strategy
                        $collection = $strategy->import();
                        
                        //Set false as default
                        $result[$file] = false;

                        //Check result
                        if ($collection instanceof Collection) {
                            //Write to disk
                            $result[$file] = $collection->writeToDisk();
                        } 
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 
     * @param string $fileName
     * @return string
     */
    private function getFileExtension($fileName) {
        $fileParts = explode('.', $fileName);
        return array_pop($fileParts);
    }

}
