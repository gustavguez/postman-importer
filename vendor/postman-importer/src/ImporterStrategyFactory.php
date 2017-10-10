<?php

namespace PostmanImporter;

use PostmanImporter\Importers\HarImporterStrategy;

/**
 * Description of ImporterStrategyFactory
 *
 * @author gustavo-rodriguez
 */
class ImporterStrategyFactory {
    
    /**
     * Factory for importer stragies 
     * 
     * @param string $fileExtension
     * @return ImporterStrategyInterface
     */
    public static function create($fileExtension){
        $importerStrategy = null;
        
        //Switch extension
        switch ($fileExtension) {
            case 'har':
                $importerStrategy = new HarImporterStrategy();
                break;
        }
        
        return $importerStrategy;
    }

}
