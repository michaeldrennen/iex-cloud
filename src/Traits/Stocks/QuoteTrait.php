<?php

namespace MichaelDrennen\IEXCloud\Traits\Stocks;


use Exception;
use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\Quote;
use MichaelDrennen\IEXCloud\Responses\Stocks\StockStats;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;

trait QuoteTrait {

    use BaseTrait;

    /**
     * @see https://iexcloud.io/docs/api/#quote
     * @param string $symbol
     * @return Quote
     */
    public function quote( string $symbol ): Quote {
        $uri      = '/stock/' . $symbol . '/quote';
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new Quote( $response );
    }


    /**
     * This method returns only the value of the field. Nothing else.
     * @param string $symbol
     * @param string $field
     * @return string
     */
    public function quoteField( string $symbol, string $field ): string {
        $uri      = '/stock/' . $symbol . '/quote/' . $field;
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return (string)$response->getBody();
    }


}
