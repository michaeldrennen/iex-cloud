<?php

namespace MichaelDrennen\IEXCloud\Traits\Stocks;


use Exception;
use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\StockStats;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;

trait KeyStatsTrait {

    use BaseTrait;

    /**
     * @see https://iexcloud.io/docs/api/#key-stats
     * @todo Perhaps add a check if sizeof $filter is > 5. After 5, IEX bills the same for getting all of the points.
     * @param string $symbol
     * @param array|NULL $filter Optionally an array of data points to include if you don't want all of them.
     * @return StockStats
     * @throws APIKeyMissing
     * @throws EndpointNotFound
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stockStats( string $symbol, array $filter = NULL ): StockStats {
        $uri = '/stock/' . $symbol . '/stats';

        $additionalQueryParameters = [];
        if ( $filter ):
            $additionalQueryParameters = [ 'filter' => implode( ',', $filter ) ];
        endif;

        $response = $this->makeRequest( 'GET', $uri, FALSE, $additionalQueryParameters );
        return new StockStats( $response );
    }


    /**
     * Use this if you only want one data point for a given stock/symbol.
     * @param string $symbol
     * @param string $stat
     * @return string Even if the data point is a float, it will return it as a string. The user can type cast on their own.
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    public function stockStat( string $symbol, string $stat ): string {
        $uri      = '/stock/' . $symbol . '/stats/' . $stat;
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return (string)$response->getBody();
    }
}
