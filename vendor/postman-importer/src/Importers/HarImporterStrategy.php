<?php

namespace PostmanImporter\Importers;

use PostmanImporter\ImporterStrategyInterface;
use PostmanImporter\Entities\Collection;
use PostmanImporter\Entities\Item;
use PostmanImporter\Entities\ItemRequest;
use PostmanImporter\Entities\ItemRequestHeader;

/**
 * Description of HarImporterStrategy
 *
 * @author gustavo-rodriguez
 */
class HarImporterStrategy implements ImporterStrategyInterface {

    /**
     * Impor logic
     */
    public function import($harContent) {
        //Check first Har content type
        if (is_array($harContent) && !empty($harContent['log'])) {
            $creator = $harContent['log']['creator'];
            $entries = $harContent['log']['entries'];

            //Create collection
            $collection = new Collection($creator['name'], $creator['version']);
            $items = [];

            //Check entries array
            if (is_array($entries) && count($entries)) {
                //For each entry
                foreach ($entries as $entry) {
                    //Parse request
                    $request = $entry['request'];
                    $headers = [];
                    
                    //Load headers
                    if (is_array($request['headers']) && count($request['headers'])) {
                        foreach ($request['headers'] as $header) {
                            //Create item header
                            $itemRequestHeader = new ItemRequestHeader();
                            $itemRequestHeader->setKey($header['name']);
                            $itemRequestHeader->setValue($header['value']);
                            $itemRequestHeader->setDescription('');
                            
                            //Push
                            $headers[] = $itemRequestHeader;
                        }
                    }

                    //create collection item
                    $item = new Item();
                    $item->setName($request['url']);

                    //Create request
                    $itemRequest = new ItemRequest();
                    $itemRequest->setBody([]);
                    $itemRequest->setDescription('');
                    $itemRequest->setHeader($headers);
                    $itemRequest->setMethod($request['method']);
                    $itemRequest->setUrl($request['url']);
                    
                    //Load item and push
                    $item->setRequest($itemRequest);
                    $items[] = $item;
                }
            }

            //Load items
            $collection->setItems($items);
            
            return $collection;
        }
    }

}
