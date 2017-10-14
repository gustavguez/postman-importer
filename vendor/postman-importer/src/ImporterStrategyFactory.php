<?php

namespace PostmanImporter;

use PostmanImporter\Importers\HarImporterStrategy;
use PostmanImporter\SourceFile;

/**
 * Description of ImporterStrategyFactory
 *
 * @author gustavo-rodriguez
 */
class ImporterStrategyFactory {
    
    /**
     * Factory for importer stragies 
     * 
     * @param SourceFile $sourceFile
     * @return ImporterStrategyInterface
     */
    public static function create(SourceFile $sourceFile){
        $importerStrategy = null;
        
        //Switch extension
        switch ($sourceFile->getExtension()) {
            case 'har':
                $importerStrategy = new HarImporterStrategy();
                break;
        }
        
        return $importerStrategy;
    }

}
