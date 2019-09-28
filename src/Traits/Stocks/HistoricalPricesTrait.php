<?php

namespace MichaelDrennen\IEXCloud\Traits\Stocks;


use Exception;
use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrices;
use MichaelDrennen\IEXCloud\Responses\StockStats;
use MichaelDrennen\IEXCloud\Traits\BaseTrait;

trait HistoricalPricesTrait {

    use BaseTrait;

    /**
     * @see https://iexcloud.io/docs/api/#historical-prices
     * @param string $symbol
     * @param string|NULL $range Valid ranges: 'max', '5y', '2y', '1y', 'ytd', '6m', '3m', '1m', '1mm', '5d', 'date', NULL
     * @param array $iexCloudQueryStringParameters
     * @param string|NULL $date
     * @param array $guzzleRequestOptions // @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return HistoricalPrices
     * @throws APIKeyMissing
     * @throws EndpointNotFound
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @note Prior trading day adjusted data available after 4am ET Tue-Sat
     */
    public function stockChart( string $symbol, string $range = NULL, array $iexCloudQueryStringParameters = [], string $date = NULL, array $guzzleRequestOptions = [] ): HistoricalPrices {
        //
        $validRanges = [
            'max', '5y', '2y', '1y', 'ytd', '6m', '3m', '1m', '1mm', '5d', 'date', NULL,
        ];

        $validIEXCloudQueryStringParameters = [
            'chartCloseOnly',
            'chartByDay',
            'chartSimplify',
            'chartInterval',
            'changeFromClose',
            'chartLast',
            'range',
            'exactDate',
            'debug',
        ];

        // Check to make sure the range parameter is a supported value.
        if ( FALSE === in_array( $range, $validRanges ) ):
            throw new Exception( "Your range param needs to be one of these values: " . implode( ', ', $validRanges ) . " See https://iexcloud.io/docs/api/#historical-prices for an explanation of those values." );
        endif;

        // Check if the user set the 'range' to 'date', but didn't pass the required date parameter.
        if ( 'date' === $range && is_null( $date ) ):
            throw new Exception( "Your 'range' parameter was set to 'date', but you did not pass in the required 'date' parameter in the function call." );
        endif;

        // Check to make sure the query parameters, if any, are all in the supported list.
        foreach ( $iexCloudQueryStringParameters as $name => $value ):
            if ( FALSE === in_array( $name, $validIEXCloudQueryStringParameters ) ):
                throw new Exception( "Your query string parameter '" . $name . "' is not in the valid list of parameters: " . implode( ', ', $validIEXCloudQueryStringParameters ) . " See https://iexcloud.io/docs/api/#historical-prices for an explanation of those values." );
            endif;
        endforeach;


        $uri = '/stock/' . $symbol . '/chart';

        if ( $range ):
            $uri .= '/' . $range;
        endif;

        // No need to check if the range was set to 'date'. That was already done in this method.
        if ( $date ):
            $uri .= '/' . $date;
        endif;

        $response = $this->makeRequest( 'GET', $uri, TRUE, $iexCloudQueryStringParameters, [], $guzzleRequestOptions );

        return new HistoricalPrices( $response );
    }
}
