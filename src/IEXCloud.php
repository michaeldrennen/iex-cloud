<?php

namespace MichaelDrennen\IEXCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Exception;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Responses\StockStats;

class IEXCloud {

    private $token;

    /**
     * @see https://iexcloud.io/docs/api/#sandbox
     * @var bool Do you want to test your code in your own sandbox with non-production data.
     */
    protected $sandbox = FALSE;

    /**
     * @see https://iexcloud.io/docs/api/#streaming
     * @var bool Do you want to use the streaming endpoints of this API?
     */
    protected $sse = FALSE;

    /**
     * @see https://iexcloud.io/docs/api/#versioning
     * @var string Which version of the IEX Cloud API do you want to access? Defaults to 'stable'
     */
    protected $version = 'stable';


    const PRODUCTION_URL     = 'https://cloud.iexapis.com/';
    const PRODUCTION_SSE_URL = 'https://cloud-sse.iexapis.com/';
    const SANDBOX_URL        = 'https://sandbox.iexapis.com/';
    const SANDBOX_SSE_URL    = 'https://sandbox-sse.iexapis.com/';


    private $baseURL;

    /**
     * @var Client $client
     */
    private $client;

    public function __construct( string $token, bool $sandbox = FALSE, bool $sse = FALSE, string $version = 'stable' ) {
        $this->token   = $token;
        $this->sandbox = $sandbox;
        $this->sse     = $sse;
        $this->version = $version;

        $this->setBaseURL();
        $this->setClient();
    }

    /**
     * Sets the base URL to be used requests to IEX Cloud API endpoints.
     * @codeCoverageIgnore
     */
    private function setBaseURL() {
        if ( $this->sandbox && $this->sse ):
            $this->baseURL = self::SANDBOX_SSE_URL;
        elseif ( $this->sandbox ):
            $this->baseURL = self::SANDBOX_URL;
        elseif ( $this->sse ):
            $this->baseURL = self::PRODUCTION_SSE_URL;
        else:
            $this->baseURL = self::PRODUCTION_URL;
        endif;
    }


    /**
     * Set up a GuzzleHttp Client with some default settings.
     */
    private function setClient() {
        $this->client = new Client( [
                                        'verify'   => FALSE,
                                        'base_uri' => $this->baseURL,
                                    ] );
    }

    /**
     * IEX Cloud offers a bunch of options (like filtering results) that are passed as part of the query string.
     * @param array $options The existing $options array used by the Guzzle client. It gets added to and returned by this function.
     * @param array $additionalQueryParameters An array of name => value pairs that will get added to the query string sent to the server.
     * @return array The modified $options array to be used by the Guzzle client.
     */
    private function setAdditionalQueryParameters( array $options, array $additionalQueryParameters = [] ): array {
        foreach ( $additionalQueryParameters as $key => $value ):
            $options[ 'query' ][ $key ] = $value;
        endforeach;

        return $options;
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $additionalQueryParameters
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws UnknownSymbol
     * @throws EndpointNotFound
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    private function makeRequest( string $method, string $uri, array $additionalQueryParameters = [] ) {

        $options = [
            'query' => [
                'token' => $this->token,
            ],
        ];

        $options = $this->setAdditionalQueryParameters( $options, $additionalQueryParameters );

        try {
            return $this->client->request( $method, $uri, $options );
        } catch ( ClientException $clientException ) {
            if ( 'Unknown symbol' === (string)$clientException->getResponse()->getBody() ):
                throw new UnknownSymbol( "IEX Cloud replied with: " . $clientException->getResponse()->getBody() );
            endif;

            if ( 'Not Found' === (string)$clientException->getResponse()->getBody() ):
                throw new EndpointNotFound( "IEX Cloud replied with: " . $clientException->getResponse()->getBody() );
            endif;
            // @codeCoverageIgnoreStart
            throw $clientException;
        } catch ( Exception $exception ) {
            throw $exception;
        }
        // @codeCoverageIgnoreEnd

    }

    public function testingNotExistentEndpoint() {
        $uri = '/endpointThatDoesNotExist/';
        $uri = $this->version . $uri;
        return $this->makeRequest( 'GET', $uri, [] );
    }


    /**
     * @see https://iexcloud.io/docs/api/#key-stats
     * @todo Perhaps add a check if sizeof $filter is > 5. After 5, IEX bills the same for getting all of the points.
     * @param string $symbol
     * @param array|NULL $filter Optionally an array of data points if you don't want all of them.
     * @return StockStats
     * @throws Exception
     */
    public function stockStats( string $symbol, array $filter = NULL ): StockStats {
        $uri = '/stock/' . $symbol . '/stats';
        $uri = $this->version . $uri;

        $additionalQueryParameters = [];
        if ( $filter ):
            $additionalQueryParameters = [ 'filter' => implode( ',', $filter ) ];
        endif;

        $response = $this->makeRequest( 'GET', $uri, $additionalQueryParameters );
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
        $uri      = $this->version . $uri;
        $response = $this->makeRequest( 'GET', $uri );
        return (string)$response->getBody();
    }


}