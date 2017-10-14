<?php

namespace PostmanImporter\Entities;

/**
 * Description of ItemRequestBody
 *
 * @author gustavo-rodriguez
 */
class ItemRequestBody {

    /**
     *
     * @var string
     */
    protected $mode;

    /**
     *
     * @var array 
     */
    protected $data;

    /**
     * 
     * @return string
     */
    public function getMode() {
        return $this->mode;
    }

    /**
     * 
     * @return string
     */
    public function getData() {
        return $this->data;
    }

    /**
     * 
     * @param string $mode
     */
    public function setMode($mode) {
        $this->mode = $mode;
    }

    /**
     * 
     * @param string $data
     */
    public function setData($data) {
        $this->data = $data;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'mode' => $this->mode,
            //Map data to array
            'formdata' => array_map(function(ItemRequestData $data) {
                        //return array representation
                        return $data->toArray();
                    }, $this->data),
        ];
    }

}
