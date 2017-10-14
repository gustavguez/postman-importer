<?php

namespace PostmanImporter\Importers;

use PostmanImporter\ImporterStrategyInterface;
use PostmanImporter\Entities\Collection;
use PostmanImporter\Entities\Item;
use PostmanImporter\Entities\ItemRequest;
use PostmanImporter\Entities\ItemRequestBody;
use PostmanImporter\Entities\ItemRequestData;
use PostmanImporter\Entities\ItemRequestHeader;

/**
 * Description of HarImporterStrategy
 *
 * @author gustavo-rodriguez
 */
class HarImporterStrategy implements ImporterStrategyInterface {

    /**
     * Impor logic, creates object for each part of har file,
     * and each part export an postmal collection json partial.
     * After creating object, just execute toArray methods and write json file.
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
                    $bodyData = [];

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

                    //Load post data
                    if (!empty($request['postData']) && !empty($request['postData']['text'])) {
                        $postData = (array) json_decode($request['postData']['text']);
                        
                        //Foreach data
                        foreach ($postData as $key => $value) {
                            $data = new ItemRequestData();
                            $data->setKey($key);
                            $data->setValue($value);
                            
                            //Push
                            $bodyData[] = $data;
                        }
                    }

                    //create collection item
                    $item = new Item();
                    $item->setName($request['url']);
                    
                    //Create request body
                    $body = new ItemRequestBody();
                    $body->setMode('formdata');
                    $body->setData($bodyData);

                    //Create request
                    $itemRequest = new ItemRequest();
                    $itemRequest->setBody($body);
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
