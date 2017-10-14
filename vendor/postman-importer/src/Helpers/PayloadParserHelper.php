<?php

namespace PostmanImporter\Helpers;

/**
 * Description of PayloadParserHelper
 *
 * @author gustavo-rodriguez
 */
class PayloadParserHelper {

    /**
     * Parse request Payload
     * 
     * @param string $type
     * @param string $body
     * @return array
     */
    public static function parse($type, $body) {
        $payload = [];

        switch (true) {
            //Application/json
            case (strpos($type, 'application/json') > -1):
                $payload = self::parseJSON($body);
                break;

            //Multipart/form-data
            case (strpos($type, 'multipart/form-data') > -1):
                $payload = self::parseFormData($type, $body);
                break;
        }

        return $payload;
    }

    /**
     * Parse Json payload
     * 
     * @param string $body
     * @return Array
     */
    public static function parseJSON($body) {
        return (array) json_decode($body);
    }

    /**
     * Parse form data payload, function taken from:
     * http://www.chlab.ch/blog/archives/webdevelopment/manually-parse-raw-http-data-php
     * 
     * @param string $type
     * @param string $input
     * @return array
     */
    public static function parseFormData($type, $input) {
        $a_data = [];
        
        // grab multipart boundary from content type header
        preg_match('/boundary=(.*)$/', $type, $matches);

        // content type is probably regular form-encoded
        if (!count($matches)) {
            // we expect regular puts to containt a query string containing data
            parse_str(urldecode($input), $a_data);
            return $a_data;
        }

        $boundary = $matches[1];

        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);

        // loop data blocks
        foreach ($a_blocks as $id => $block) {
            if (empty($block))
                continue;

            // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char
            // parse uploaded files
            if (strpos($block, 'application/octet-stream') !== FALSE) {
                // match "name", then everything after "stream" (optional) except for prepending newlines
                preg_match("/name=\"([^\"]*)\".*stream[\n|\r]+([^\n\r].*)?$/s", $block, $matches);
                $a_data['files'][$matches[1]] = $matches[2];
            }
            // parse all other fields
            else {
                // match "name" and optional value in between newline sequences
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);
                $a_data[$matches[1]] = $matches[2];
            }
        }

        return $a_data;
    }

}
