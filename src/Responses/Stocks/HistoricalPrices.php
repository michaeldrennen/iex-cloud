<?php

namespace MichaelDrennen\IEXCloud\Responses\Stocks;

use MichaelDrennen\IEXCloud\Responses\IEXCloudResponse;


class HistoricalPrices extends IEXCloudResponse {

    public $prices;


    public function __construct( $response ) {
        $jsonString                 = (string)$response->getBody();
        $arrayOfPrices                         = \GuzzleHttp\json_decode( $jsonString, TRUE );

        foreach($arrayOfPrices as $price):
            $this->prices[] = new HistoricalPrice($price);
        endforeach;
    }

}