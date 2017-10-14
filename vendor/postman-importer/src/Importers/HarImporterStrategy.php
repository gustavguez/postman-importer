<?php

namespace PostmanImporter\Importers;

use PostmanImporter\ImporterStrategyInterface;
use PostmanImporter\SourceFile;
use PostmanImporter\Collection\Collection;
use PostmanImporter\Collection\Item;
use PostmanImporter\Collection\ItemRequest;
use PostmanImporter\Collection\ItemRequestBody;
use PostmanImporter\Collection\ItemRequestData;
use PostmanImporter\Collection\ItemRequestHeader;

/**
 * Description of HarImporterStrategy
 *
 * @author gustavo-rodriguez
 */
class HarImporterStrategy implements ImporterStrategyInterface {

    /**
     * Ignore regex urls
     * @var array 
     */
    protected static $ignoreURLS = [
        '/[\w\-]+\.(jpg|jpeg|gif|png|bmp|svg|js)/',
        '/maps.google(\.com)?/'
    ];
    
    /**
     * Ignore headers names
     * @var array 
     */
    protected static $ignoreHeaders = [
        'Content-Type', //Breaks Postman payload
    ];

    /**
     * Impor logic, creates object for each part of har file,
     * and each part export an postmal collection json partial.
     * After creating object, just execute toArray methods and write json file.
     * 
     * @param SourceFile $sourceFile
     * @return Collection
     */
    public function import(SourceFile $sourceFile) {
        $harContent = $sourceFile->getContent();

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
                    
                    //Check ignored urls
                    if(!$this->validateURL($request['url'])){
                        continue;
                    }

                    //Load headers
                    if (is_array($request['headers']) && count($request['headers'])) {
                        foreach ($request['headers'] as $header) {
                            //Check ignored headers
                            if(in_array($header['name'], self::$ignoreHeaders)){
                                continue;
                            }
                            
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
    
    /**
     * Validate url
     * 
     * @param string $url
     * @return boolean
     */
    protected function validateURL($url){
        $valid = true;
        
        //For each validate regex
        for ($index = 0; $index < count(self::$ignoreURLS) && $valid; $index++) {
            preg_match(self::$ignoreURLS[$index], $url, $matches);
            
            //Load valid
            $valid = count($matches) === 0;
        }
        
        return $valid;
    }

}
