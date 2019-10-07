<?php

namespace MichaelDrennen\IEXCloud\Responses\Stocks;


use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


class Company extends IEXCloudResponse {

    public $symbol;             // Ex: AAPL
    public $companyName;
    public $exchange;
    public $industry;
    public $website;
    public $description;
    public $CEO;
    public $securityName;
    public $issueType;
    public $sector;
    public $employees;
    public $tags;
    public $address;
    public $address2;
    public $state;
    public $city;
    public $zip;
    public $country;
    public $phone;


    public function __construct( $response ) {
        $jsonString         = (string)$response->getBody();
        $a                  = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->symbol       = $a[ 'symbol' ] ?? NULL;
        $this->companyName  = $a[ 'companyName' ] ?? NULL;
        $this->exchange     = $a[ 'exchange' ] ?? NULL;
        $this->industry     = $a[ 'industry' ] ?? NULL;
        $this->website      = $a[ 'website' ] ?? NULL;
        $this->description  = $a[ 'description' ] ?? NULL;
        $this->CEO          = $a[ 'CEO' ] ?? NULL;
        $this->securityName = $a[ 'securityName' ] ?? NULL;
        $this->issueType    = $a[ 'issueType' ] ?? NULL;
        $this->sector       = $a[ 'sector' ] ?? NULL;
        $this->employees    = $a[ 'employees' ] ?? NULL;
        $this->tags         = $a[ 'tags' ] ?? NULL;
        $this->address      = $a[ 'address' ] ?? NULL;
        $this->address2     = $a[ 'address2' ] ?? NULL;
        $this->state        = $a[ 'state' ] ?? NULL;
        $this->city         = $a[ 'city' ] ?? NULL;
        $this->zip          = $a[ 'zip' ] ?? NULL;
        $this->country      = $a[ 'country' ] ?? NULL;
        $this->phone        = $a[ 'phone' ] ?? NULL;


    }

}