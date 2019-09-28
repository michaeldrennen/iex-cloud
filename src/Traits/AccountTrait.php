<?php

namespace MichaelDrennen\IEXCloud\Traits;


use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\Account\Metadata;
use MichaelDrennen\IEXCloud\Responses\Account\Usage;

trait AccountTrait {

    use BaseTrait;

    /**
     * @see https://iexcloud.io/docs/api/#metadata
     * @return Metadata
     * @throws APIKeyMissing
     * @throws EndpointNotFound
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
     * @throws APIKeyMissing
     * @throws EndpointNotFound
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
     * @throws APIKeyMissing
     * @throws EndpointNotFound
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
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
}
