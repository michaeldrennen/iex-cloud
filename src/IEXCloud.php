<?php

namespace MichaelDrennen\IEXCloud;

use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use MichaelDrennen\IEXCloud\Exceptions\APIKeyMissing;
use MichaelDrennen\IEXCloud\Exceptions\EndpointNotFound;
use MichaelDrennen\IEXCloud\Exceptions\UnknownSymbol;
use MichaelDrennen\IEXCloud\Traits\AccountTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\HistoricalPricesTrait;
use MichaelDrennen\IEXCloud\Traits\Stocks\KeyStatsTrait;

class IEXCloud {

    use AccountTrait;
    use KeyStatsTrait;
    use HistoricalPricesTrait;


    protected $PRODUCTION_URL     = 'https://cloud.iexapis.com/';
    protected $PRODUCTION_SSE_URL = 'https://cloud-sse.iexapis.com/';
    protected $SANDBOX_URL        = 'https://sandbox.iexapis.com/';
    protected $SANDBOX_SSE_URL    = 'https://sandbox-sse.iexapis.com/';

    /**
     * @see https://iexcloud.io/console/tokens
     * @var string
     */
    protected $publishableToken;


    /**
     * @see https://iexcloud.io/console/tokens
     * @var string
     */
    protected $secretToken;


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


    protected $baseURL;

    /**
     * @var Client $client
     */
    protected $client;


    /**
     * IEXCloud constructor.
     * @param string $publishableToken
     * @param string $secretToken
     * @param bool $sandbox
     * @param bool $sse
     * @param string $version
     */
    public function __construct( string $publishableToken, string $secretToken, bool $sandbox = FALSE, bool $sse = FALSE, string $version = 'stable' ) {
        $this->publishableToken = $publishableToken;
        $this->secretToken      = $secretToken;
        $this->sandbox          = $sandbox;
        $this->sse              = $sse;
        $this->version          = $version;

        $this->setBaseURL();
        $this->setClient();
    }

    /**
     * Sets the base URL to be used requests to IEX Cloud API endpoints.
     * @codeCoverageIgnore
     */
    protected function setBaseURL() {
        if ( $this->sandbox && $this->sse ):
            $this->baseURL = $this->SANDBOX_SSE_URL;
        elseif ( $this->sandbox ):
            $this->baseURL = $this->SANDBOX_URL;
        elseif ( $this->sse ):
            $this->baseURL = $this->PRODUCTION_SSE_URL;
        else:
            $this->baseURL = $this->PRODUCTION_URL;
        endif;
    }


    /**
     * Set up a GuzzleHttp Client with some default settings.
     */
    protected function setClient() {
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
    protected function setAdditionalQueryParameters( array $options, array $additionalQueryParameters = [] ): array {
        foreach ( $additionalQueryParameters as $key => $value ):
            $options[ 'query' ][ $key ] = $value;
        endforeach;

        return $options;
    }


    protected function setAdditionalFormParams( array $options, array $additionalFormParameters = [] ): array {
        foreach ( $additionalFormParameters as $key => $value ):
            $options[ 'form_params' ][ $key ] = $value;
        endforeach;

        return $options;
    }


    /**
     * I originally created this method to pass the debug flag into the GuzzleHTTP request options
     * for development and testing.
     * @param array $options
     * @param array $guzzleRequestOptions
     * @return array
     * @see http://docs.guzzlephp.org/en/stable/request-options.html
     */
    protected function setGuzzleRequestOptions( array $options, array $guzzleRequestOptions ): array {
        foreach ( $guzzleRequestOptions as $key => $value ):
            $options[ $key ] = $value;
        endforeach;
        return $options;
    }


    /**
     * Some of the IEX Cloud API endpoints require the secret token. These are primarily endpoints that effect your account.
     * @param bool $requiresSecretToken
     * @return string
     */
    protected function getProperToken( bool $requiresSecretToken = FALSE ) {
        if ( $requiresSecretToken ):
            return $this->secretToken;
        endif;
        return $this->publishableToken;
    }


    /**
     * @param string $method
     * @param string $uri
     * @param bool $requiresSecretToken
     * @param array $additionalQueryParameters
     * @param array $formParams Parameters for a POST request.
     * @param array $guzzleRequestOptions // @see http://docs.guzzlephp.org/en/stable/request-options.html
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws APIKeyMissing
     * @throws EndpointNotFound
     * @throws UnknownSymbol
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws Exception
     */
    protected function makeRequest( string $method, string $uri, bool $requiresSecretToken = FALSE, array $additionalQueryParameters = [], array $formParams = [], array $guzzleRequestOptions = [] ) {

        if ( 'GET' === $method ):
            $options = [
                'query'       => [
                    'token' => $this->getProperToken( $requiresSecretToken ),
                ],
                'form_params' => NULL,
            ];
        else:
            $options = [
                'query' => [
                    'token' => $this->getProperToken( $requiresSecretToken ),
                ],

                'form_params' => [
                    'token' => $this->getProperToken( $requiresSecretToken ),
                ],
            ];
        endif;


        $options = $this->setAdditionalQueryParameters( $options, $additionalQueryParameters );
        $options = $this->setAdditionalFormParams( $options, $formParams );
        $options = $this->setGuzzleRequestOptions( $options, $guzzleRequestOptions );


        // Add the version to the URI before the request is made.
        $uri = $this->version . $uri;

        try {
            return $this->client->request( $method, $uri, $options );
        } catch ( ClientException $clientException ) {
            if ( 'Unknown symbol' === (string)$clientException->getResponse()->getBody() ):
                throw new UnknownSymbol( "IEX Cloud replied with: " . $clientException->getResponse()->getBody() );
            endif;

            if ( 'Not Found' === (string)$clientException->getResponse()->getBody() ):
                throw new EndpointNotFound( "IEX Cloud replied with: " . $clientException->getResponse()->getBody() );
            endif;

            if ( 'An API key is required to access this data and no key was provided' === (string)$clientException->getResponse()->getBody() ):
                throw new APIKeyMissing( "IEX Cloud replied with: " . $clientException->getResponse()->getBody() );
            endif;


            // @codeCoverageIgnoreStart
            throw $clientException;
        } catch ( Exception $exception ) {
            throw $exception;
        }
        // @codeCoverageIgnoreEnd

    }

    // START FUNCTIONS THAT ARE ONLY MEANT TO BE USED DURING TESTING.
    public function testingNotExistentEndpoint() {
        $uri = '/endpointThatDoesNotExist/';
        return $this->makeRequest( 'GET', $uri, FALSE, [] );
    }

    public function testingValidRequestWithEmptyToken() {
        $uri = '/stock/AAPL/stats';
        return $this->makeRequest( 'GET', $uri, FALSE, [ 'token' => NULL ] );
    }
    // END FUNCTIONS THAT ARE ONLY MEANT TO BE USED DURING TESTING.


}