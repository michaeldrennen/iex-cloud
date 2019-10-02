<?php

namespace MichaelDrennen\IEXCloud\Traits\IEX;


use Exception;
use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\IEX\LastTrades;
use MichaelDrennen\IEXCloud\Responses\Stocks\StockStats;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;

trait LastTrait {

    use BaseTrait;


    /**
     * @see https://iexcloud.io/docs/api/#last
     * @param array $symbols
     * @return LastTrades
     */
    public function last( array $symbols ): LastTrades {
        throw new Exception("Currently does not work. IEX Cloud returns 404 api endpoint not found for /last");
        $uri = '/last';

        $additionalQueryParameters = ['symbols' => $symbols];
        $formParams = [];
        $guzzleRequestOptions = [
            'debug' => true
        ];

        $response = $this->makeRequest( 'GET', $uri, FALSE, $additionalQueryParameters, $formParams, $guzzleRequestOptions  );

        return new LastTrades( $response );
    }



}
