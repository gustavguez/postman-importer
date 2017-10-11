<?php

namespace PostmanImporter\Entities;

/**
 * Description of Item
 *
 * @author gustavo-rodriguez
 */
class Item {

    /**
     *
     * @var string 
     */
    protected $name;

    /**
     *
     * @var ItemEvent 
     */
    protected $event;

    /**
     *
     * @var ItemRequest 
     */
    protected $request;

    /**
     * 
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * 
     * @return ItemEvent
     */
    public function getEvent() {
        return $this->event;
    }

    /**
     * 
     * @return ItemRequest
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * 
     * @param string $name
     */
    public function setName($name) {
        $this->name = $name;
    }

    /**
     * 
     * @param ItemEvent $event
     */
    public function setEvent(ItemEvent $event) {
        $this->event = $event;
    }

    /**
     * 
     * @param ItemRequest $request
     */
    public function setRequest(ItemRequest $request) {
        $this->request = $request;
    }

    /**
     * 
     * @return array
     */
    public function toArray() {
        return [
            'name' => $this->name,
            'event' => $this->event instanceof ItemEvent ? $this->event->toArray() : [],
            'request' => $this->request instanceof ItemRequest ? $this->request->toArray() : [],
        ];
    }

}
