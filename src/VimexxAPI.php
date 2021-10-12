<?php
namespace Ben221199\Vimexx\API;

class VimexxAPI{

    private $baseURL;
    private $isTesting;
    private $version;

    private $token;

    public function __construct($baseURL,$isTesting,$version){
        $this->baseURL = $baseURL;
        $this->isTesting = $isTesting;
        $this->version = $version;
    }

    function createURL($prefix,$endpoint){
        return ($this->isTesting?'/testapi':'/api').'/v1'.$prefix.$endpoint;
    }

    function fetch(string $method,string $endpoint,array $headers,$body=null){
        $ch = curl_init($this->baseURL.$endpoint);
        curl_setopt($ch,CURLOPT_CUSTOMREQUEST,$method);
        array_walk($headers,static function(string &$value,string $key){
            $value = $key.': '.$value;
        });
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        if($body){
            curl_setopt($ch,CURLOPT_POSTFIELDS,$body);
        }
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $resp = curl_exec($ch);
        curl_close($ch);

        return $resp;
    }

    function fetchWithToken(string $method,string $endpoint,array $headers,$body=null){
        return $this->fetch($method,$endpoint,array_merge($headers,[
            'Authorization'		=> 'Bearer '.$this->token,
            'Content-Type'		=> 'application/json',
        ]),json_encode([
            'body'		=> $body,
            'version'	=> $this->version,
        ]));
    }

    public function getAuthToken(string $client_id,string $client_secret,string $username,string $password){
        return $this->fetch('POST','/auth/token',[
            'Content-Type'		=> 'application/x-www-form-urlencoded',
        ],http_build_query([
            'grant_type'		=> 'password',
            'client_id'			=> $client_id,
            'client_secret'		=> $client_secret,
            'username'			=> $username,
            'password'			=> $password,
            'scope'				=> 'whmcs-access',
        ]));
    }

    public function getWeFact(){
        return new WeFactVimexxAPI($this);
    }

    public function getWHMCS(){
        return new WHMCSVimexxAPI($this);
    }

    public function setToken(string $token){
        $this->token = $token;
    }

}