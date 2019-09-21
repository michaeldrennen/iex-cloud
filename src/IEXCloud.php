<?php
//test
namespace MichaelDrennen\IEXCloud;

use Exception;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Account\Metadata;
use MichaelDrennen\IEXCloud\Responses\Account\Usage;
use MichaelDrennen\IEXCloud\Responses\AccountMetadata;
use MichaelDrennen\IEXCloud\Responses\Reference\Symbols;
use MichaelDrennen\IEXCloud\Responses\Reference\SearchResults;
use MichaelDrennen\IEXCloud\Responses\Stocks\HistoricalPrices;
use MichaelDrennen\IEXCloud\Responses\StockStats;

/**
 * Class IEXCloud
 * @package MichaelDrennen\IEXCloud
 */
class IEXCloud extends IEXCloudBase {


    /**
     * @return Metadata
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountMetadata(): Metadata {
        $uri      = '/account/metadata';
        $response = $this->makeRequest( 'GET', $uri, TRUE );
        return new Metadata( $response );
    }


    /**
     * @see https://iexcloud.io/docs/api/#usage
     * @param string|NULL $type Optional. Used to specify which quota to return. Ex: messages, rules, rule-records, alerts, alert-records
     * @return Usage
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accountUsage( string $type = NULL ): Usage {
        if ( $type ):
            $uri = '/account/usage/' . $type;
        else:
            $uri = '/account/usage';
        endif;

        $response = $this->makeRequest( 'GET', $uri, TRUE );
        return new Usage( $response );
    }

    /**
     * @param bool $allow
     * @return bool
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @see https://iexcloud.io/docs/api/#pay-as-you-go
     */
    public function payAsYouGo( bool $allow ): bool {
        $uri = '/account/payasyougo';

        $additionalQueryParameters = [
            'allow' => $allow,
            'token' => NULL,
        ];
        $response                  = $this->makeRequest( 'POST', $uri, TRUE, [], $additionalQueryParameters );
        var_dump( $response );
        $jsonString = (string)$response->getBody();
        print_r( $jsonString );
        $a = \GuzzleHttp\json_decode( $jsonString, TRUE );
        print_r( $a );
    }


    /**
     * @see https://iexcloud.io/docs/api/#key-stats
     * @todo Perhaps add a check if sizeof $filter is > 5. After 5, IEX bills the same for getting all of the points.
     * @param string $symbol
     * @param array|NULL $filter Optionally an array of data points if you don't want all of them.
     * @return StockStats
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
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


    /**
     * @param string $symbol
     * @param string|NULL $range
     * @param array $queryStringParameters
     * @param string|NULL $date
     * @return HistoricalPrices
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @note Prior trading day adjusted data available after 4am ET Tue-Sat
     * @see https://iexcloud.io/docs/api/#historical-prices
     */
    public function stockChart( string $symbol, string $range = NULL, array $queryStringParameters = [], string $date = NULL ): HistoricalPrices {
        //
        $validRanges = [
            'max', '5y', '2y', '1y', 'ytd', '6m', '3m', '1m', '1mm', '5d', 'date', NULL,
        ];

        $validQueryStringParameters = [
            'chartCloseOnly',
            'chartByDay',
            'chartSimplify',
            'chartInterval',
            'changeFromClose',
            'chartLast',
            'range',
            'exactDate',
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
        foreach ( $queryStringParameters as $name => $value ):
            if ( FALSE === in_array( $name, $validQueryStringParameters ) ):
                throw new Exception( "Your query string parameter '" . $name . "' is not in the valid list of parameters: " . implode( ', ', $validQueryStringParameters ) . " See https://iexcloud.io/docs/api/#historical-prices for an explanation of those values." );
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

        $response = $this->makeRequest( 'GET', $uri, TRUE, $queryStringParameters );

        return new HistoricalPrices( $response );
    }


    /**
     * Returns an array of symbols up to the top 10 matches.
     * Results will be sorted for relevancy.
     * Search currently defaults to equities only, where the symbol returned is supported by endpoints listed under the Stocks category.
     * This endpoint is useful for creating an autocomplete search box.
     * @param string $fragment
     * @return string
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @see https://iexcloud.io/docs/api/#search
     */
    public function search( string $fragment ): SearchResults {
        $uri      = '/search/' . $fragment;
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new SearchResults( $response );
    }


    /**
     * @return Symbols
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function symbols(): Symbols {
        $uri      = '/ref-data/symbols';
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new Symbols( $response );
    }


    /**
     * Returns an array of symbols the Investors Exchange supports for trading
     * @return Symbols
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function iexSymbols(): Symbols {
        $uri      = '/ref-data/iex/symbols';
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new Symbols( $response );
    }

    /**
     * @param string $region
     * @return Symbols
     * @throws EndpointNotFound
     * @throws Exceptions\APIKeyMissing
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function symbolsInternational(string $region ): Symbols {
        $uri      = '/ref-data/region/' . $region . '/symbols';
        $response = $this->makeRequest( 'GET', $uri, FALSE );
        return new Symbols( $response );
    }
}