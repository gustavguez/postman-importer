<?php

namespace PostmanImporter\Collection;

/**
 * Description of ItemRequest
 *
 * @author gustavo-rodriguez
 */
class ItemRequest {

    /**
     *
     * @var string
     */
    protected $url;

    /**
     *
     * @var string 
     */
    protected $method;

    /**
     *
     * @var array 
     */
    protected $header;

    /**
     *
     * @var ItemRequestBody 
     */
    protected $body;

    /**
     *
     * @var string 
     */
    protected $description;

    /**
     * 
     * @return string
     */
    public function getUrl() {
        return $this->url;
    }

    /**
     * 
     * @return string
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * 
     * @return array
     */
    public function getHeader() {
        return $this->header;
    }

    /**
     * 
     * @return ItemRequestBody
     */
    public function getBody() {
        return $this->body;
    }

    /**
     * 
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * 
     * @param string $url
     */
    public function setUrl($url) {
        $this->url = $url;
    }

    /**
     * 
     * @param string $method
     */
    public function setMethod($method) {
        $this->method = $method;
    }

    /**
     * 
     * @param array $header
     */
    public function setHeader($header) {
        $this->header = $header;
    }

    /**
     * 
     * @param ItemRequestBody $body
     */
    public function setBody(ItemRequestBody $body) {
        $this->body = $body;
    }

    /**
     * 
     * @param string $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'url' => $this->url,
            'body' => $this->body instanceof ItemRequestBody ? $this->body->toArray() : [],
            'description' => $this->description,
            'method' => $this->method,
            //Map headers to array
            'header' => array_map(function(ItemRequestHeader $header) {
                        //return array representation
                        return $header->toArray();
                    }, $this->header),
        ];
    }

}
