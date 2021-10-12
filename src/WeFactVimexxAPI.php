<?php
namespace Ben221199\Vimexx\API;

class WeFactVimexxAPI{

    private const PREFIX = '/wefact';

    private $api;

    function __construct(VimexxAPI $api){
        $this->api = $api;
    }

    public function checkDomainAvailable(string $sld,string $tld){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain/available'),[],[
            'sld'	=> $sld,
            'tld'	=> $tld,
        ]));
    }

    public function registerDomain(string $sld,string $tld){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain/register'),[],[
            'sld'	=> $sld,
            'tld'	=> $tld,
        ]));
    }

    public function transferDomain(string $sld,string $tld,string $token){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain/transfer'),[],[
            'sld'	=> $sld,
            'tld'	=> $tld,
            'token'	=> $token,
        ]));
    }

    public function extendDomain(string $sld,string $tld,string $years){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain/extend'),[],[
            'sld'	=> $sld,
            'tld'	=> $tld,
            'years'	=> $years,
        ]));
    }

    public function getDomain(string $sld,string $tld){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain'),[],[
            'sld'	=> $sld,
            'tld'	=> $tld,
        ]));
    }

    public function getDomains(){
        return json_decode($this->api->fetchWithToken('POST',$this->api->createURL(self::PREFIX,'/domain'),[],null));
    }

}