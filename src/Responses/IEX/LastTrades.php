<?php

namespace MichaelDrennen\IEXCloud\Responses\IEX;


use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


class LastTrades extends IEXCloudResponse {

    public $lastTrades;



    public function __construct( $response ) {
        $jsonString                = (string)$response->getBody();
        $a                         = \GuzzleHttp\json_decode( $jsonString, TRUE );
        print_r($a);

    }

}