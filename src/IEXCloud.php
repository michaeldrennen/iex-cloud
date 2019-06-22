<?php

namespace MichaelDrennen\IEXCloud;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

use Exception;
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
     * @see https://iexcloud.io/docs/api/#key-stats
     * @param string $symbol
     * @param string|NULL $stat
     * @return StockStats
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function stockStats( string $symbol ): StockStats {
        $uri      = '/stock/' . $symbol . '/stats';
        $uri      = $this->version . $uri;
        $response = $this->makeRequest( 'GET', $uri );
        return new StockStats( $response );
    }

    public function stockStat( string $symbol, string $stat ): string {
        $uri      = '/stock/' . $symbol . '/stats/' . $stat;
        $uri      = $this->version . $uri;
        $response = $this->makeRequest( 'GET', $uri );
        return (string)$response->getBody();
    }


    /**
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function makeRequest( string $method, string $uri ) {

        $options = [
            'query' => [
                'token' => $this->token,
            ],
        ];

        try {
            return $this->client->request( $method, $uri, $options );
        } catch ( ClientException $clientException ) {
            if ( 'Unknown symbol' == $clientException->getResponse()->getBody() ):
                throw $clientException;
                //throw new UnknownSymbol( "IEXTrading.com replied with: " . $clientException->getResponse()->getBody() );
            endif;
            throw $clientException;
        } catch ( Exception $exception ) {
            throw $exception;
        }
    }
}