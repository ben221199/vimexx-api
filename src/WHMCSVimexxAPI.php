<?php
namespace Ben221199\Vimexx\API;

class WHMCSVimexxAPI{

    private const PREFIX = '/whmcs';

    private $api;

    function __construct(VimexxAPI $api){
        $this->api = $api;
    }

}