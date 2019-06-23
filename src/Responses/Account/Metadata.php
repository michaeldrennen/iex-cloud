<?php

namespace MichaelDrennen\IEXCloud\Responses\Account;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;

/**
 * Class AccountMetadata
 * @package MichaelDrennen\IEXCloud\Responses
 */
class Metadata extends IEXCloudResponse {

    public $payAsYouGoEnabled;
    public $effectiveDate;
    public $subscriptionTermType;
    public $tierName;
    public $messageLimit;
    public $messagesUsed;
    public $circuitBreaker;


    public function __construct( $response ) {
        $jsonString                 = (string)$response->getBody();
        $a                          = \GuzzleHttp\json_decode( $jsonString, TRUE );
        $this->payAsYouGoEnabled    = $a[ 'payAsYouGoEnabled' ] ?? NULL;
        $this->effectiveDate        = $a[ 'effectiveDate' ] ?? NULL;
        $this->subscriptionTermType = $a[ 'subscriptionTermType' ] ?? NULL;
        $this->tierName             = $a[ 'tierName' ] ?? NULL;
        $this->messageLimit         = $a[ 'messageLimit' ] ?? NULL;
        $this->messagesUsed         = $a[ 'messagesUsed' ] ?? NULL;
        $this->circuitBreaker       = $a[ 'circuitBreaker' ] ?? NULL;
    }

}