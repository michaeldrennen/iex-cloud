<?php

namespace MichaelDrennen\IEXCloud;

use Exception;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Account\Metadata;
use MichaelDrennen\IEXCloud\Responses\Account\Usage;
use MichaelDrennen\IEXCloud\Responses\AccountMetadata;
use MichaelDrennen\IEXCloud\Responses\StockStats;

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

    public function payAsYouGo( bool $allow ): bool {
        $uri = '/account/payasyougo';

        $formParams = [
//            'token' => $this->getProperToken( TRUE ),
            'allow' => $allow,
        ];
        $response = $this->makeRequest( 'POST', $uri, TRUE, [], $formParams );
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


}