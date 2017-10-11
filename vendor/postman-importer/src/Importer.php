<?php

namespace PostmanImporter;

use PostmanImporter\Entities\Collection;
use Exception;

/**
 * Description of Importer
 *
 * @author gustavo-rodriguez
 */
class Importer {

    const SOURCE_DIRECTORY = '/src/';
    const DESTINATION_DIRECTORY = '/dist/';

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
        $srcDir = $this->baseUrl . self::SOURCE_DIRECTORY;
        $distDir = $this->baseUrl . self::DESTINATION_DIRECTORY;

        //Control directory
        if (is_dir($srcDir)) {

            //Read files
            $files = scandir($srcDir);

            //Control scandir resturn
            if (is_array($files) && count($files)) {
                foreach ($files as $file) {
                    //Get file extension
                    $fileExtension = $this->getFileExtension($file);

                    //Get importer strategy
                    $strategy = ImporterStrategyFactory::create($fileExtension);

                    //Check strategy
                    if ($strategy instanceof ImporterStrategyInterface) {
                        //Load file
                        $fileContent = $this->getFileContent($srcDir, $file);

                        //Import strategy
                        $collection = $strategy->import($fileContent);

                        //Set false as default
                        $result[$file] = false;

                        //Check result
                        if ($collection instanceof Collection) {
                            //Write to disk
                            $result[$file] = $this->writeCollectionToDisk($collection, $distDir, $file);
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

    /**
     * 
     * @param string $fileName
     * @return string
     */
    private function getFileName($fileName) {
        $fileParts = explode('.', $fileName);
        array_pop($fileParts);
        return implode('.', $fileParts);
    }

    /**
     * 
     * @param string $fileName
     * @return array
     */
    private function getFileContent($baseUrl, $fileName) {
        $fileContent = [];

        try {
            //Get file content
            $aux = file_get_contents($baseUrl . $fileName);

            //Get decoded content
            $fileContent = json_decode($aux, true);
        } catch (Exception $exc) {
            //Do nothing
        }

        return $fileContent;
    }

    /**
     * 
     * @param string $fileName
     * @return array
     */
    private function writeCollectionToDisk(Collection $collection, $baseUrl, $originalFileName) {
        $result = false;

        try {
            //Parse base name
            $baseName = sprintf('%s.%s', $this->getFileName($originalFileName), Collection::EXTENSION);
            
            //Get collection array
            $array = $collection->toArray();
            
            //File put content
            $result = (file_put_contents($baseUrl.$baseName, json_encode($array, JSON_UNESCAPED_SLASHES)) > 0);
        } catch (Exception $exc) {
            //Do nothing
        }

        return $result;
    }

}
