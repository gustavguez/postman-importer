<?php

namespace PostmanImporter;

use PostmanImporter\Collection\Collection;
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
                    //Create sosurceFile
                    $sourceFile = new SourceFile($srcDir, $file);

                    //Get importer strategy
                    $strategy = ImporterStrategyFactory::create($sourceFile);

                    //Check strategy
                    if ($strategy instanceof ImporterStrategyInterface) {
                        //Import strategy
                        $collection = $strategy->import($sourceFile);

                        //Set false as default
                        $result[$file] = false;

                        //Check result
                        if ($collection instanceof Collection) {
                            //Write to disk
                            $result[$file] = $this->writeCollectionToDisk($collection, $distDir, $sourceFile);
                        }
                    }
                }
            }
        }
        return $result;
    }

    /**
     * 
     * @param SourceFile $sourceFile
     * @return array
     */
    private function writeCollectionToDisk(Collection $collection, $baseUrl, SourceFile $sourceFile) {
        $result = false;

        try {
            $fileName = $sourceFile->getName();
            
            //Parse base name
            $baseName = sprintf('%s.%s', $fileName, Collection::EXTENSION);

            //Get collection array
            $array = $collection->toArray();

            //File put content
            $result = (file_put_contents($baseUrl . $baseName, json_encode($array, JSON_UNESCAPED_SLASHES)) > 0);
        } catch (Exception $exc) {
            //Do nothing
        }

        return $result;
    }

}
